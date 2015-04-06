//import packages
var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");
 
//create server on port 3456
var app = http.createServer(function(req, resp){
	fs.readFile("chatroom.html", function(err, data){
		if(err) return resp.writeHead(500);
		resp.writeHead(200);
		resp.end(data);
	});
});
app.listen(3456);
 

var io = socketio.listen(app);

//room and user information
var room_to_identity = {"common_room": []};
var room_to_user = {"common_room":[] };
var categorty_to_room = {"sports":[], "movies":[], "others":[], "technology":[], "society":[], "travel":[], "politics":[], "life":[]};
var room_to_admin = {};
var room_to_password = {};
var public_rooms = [];
var private_rooms = [];
var blacklist = {"common_room": []};

io.sockets.on("connection", function(socket){

	//confirm connection done to client
	io.sockets.to(socket.id).emit("connection_done", {user_id: socket.id});
    
    //send message to client
	socket.on('message_to_server', function(data) {
		console.log("message: "+data["message"]); 
		io.sockets.emit("message_to_client",{message:data["message"], message_username:data["message_username"], message_room: data['message_room']}); 
	});
    

    //update username in the room
	socket.on('set_username', function(data){
		var user_in_this_room = room_to_user["common_room"];
        user_in_this_room[user_in_this_room.length] = data["username"];

        var identity_in_this_room = room_to_identity["common_room"];
        identity_in_this_room[identity_in_this_room.length] = [data['username'], socket.id];

        console.log("Add new user " + data["username"] + "to common_room");
  
	});



    //client requests to join a public room
	socket.on('join_public_room', function(data){
		var room_name = data["join_room_name"];
		var join_username = data["join_username"];
		var user_in_this_room = room_to_user[room_name];
        user_in_this_room[user_in_this_room.length] = join_username;

        var identity_in_this_room = room_to_identity[room_name];
        identity_in_this_room[identity_in_this_room.length] = [join_username, socket.id];
	});

    //client requests to join a private room
	socket.on('private_room_join', function(data){
		var room_username = data['room_username'];
		var private_room_name = data['private_room_name'];
		var private_room_password = data['private_room_password'];

		var join_private_success = true;

		//check black list
		for(var key in blacklist){
			if(key === private_room_name){
				var users_to_check = blacklist[key];
				if(users_to_check.indexOf(room_username) != -1){
					join_private_success = false;
					break;
				}
			}
		}

        //check password
		if(join_private_success){
			var correct_password = room_to_password[private_room_name];
			if(correct_password !== private_room_password){
				join_private_success = false;
			}
		}

		if(join_private_success){
			var user_in_this_room = room_to_user[private_room_name];
            user_in_this_room[user_in_this_room.length] = room_username;
            var identity_in_this_room = room_to_identity[private_room_name];
            identity_in_this_room[identity_in_this_room.length] = [room_username, socket.id];

		}

		io.sockets.to(socket.id).emit("join_private_check", {join_result: join_private_success, join_room_name: private_room_name});

	});


    //client requests to create a new room
	socket.on('create_new_room', function(data){
		var create_new_room_name = data['create_new_room_name'];
		var create_new_room_password = data['create_new_room_password'];
		var room_admin = data['room_admin'];
		var create_new_room_category = data['create_new_room_category'];

		room_to_user[create_new_room_name] = [room_admin];
		room_to_admin[create_new_room_name] = room_admin;
		room_to_identity[create_new_room_name] = [[room_admin, socket.id]];


		if(create_new_room_password.length != 0){
			room_to_password[create_new_room_name] = create_new_room_password;
			private_rooms[private_rooms.length] = create_new_room_name;
		}else{
			public_rooms[public_rooms.length] = create_new_room_name;
			var select_category = categorty_to_room[create_new_room_category];
		    select_category[select_category.length] = create_new_room_name;
		}

		io.sockets.to(socket.id).emit("join", {room_to_join: create_new_room_name});
	});
    

    //client requests to leave a room
	socket.on('leave_room', function(data){
		var leave_room = data["leave_room_name"];
		var leave_username = data["leave_username"];


		var user_index = room_to_user[leave_room].indexOf(leave_username);
		room_to_user[leave_room].splice(user_index, 1);

		var ids = room_to_identity[leave_room];
		for(var i in ids){
			if(ids[i][0] === leave_username){
				ids.splice(i, 1);
				break;
			}
		}

		console.log("Remove " + leave_username + " from " + leave_room);

	});
    

    //client requests the list of users in the room
	socket.on('find_users_in_room', function(data){
		var update_room_name = data['update_room_name'];
		var usersInRoom = room_to_user[update_room_name];
		io.sockets.emit("update_users_in_room", {users_in_room: usersInRoom, in_room: update_room_name});
	});


    //client requests to check if he is admin
	socket.on('am_i_admin', function(data){
		var my_name = data['my_name'];
		var isAdmin = false;
		var admin_room = [];

		for(var i=0; i<Object.keys(room_to_admin).length; i++){
		
			if(room_to_admin[Object.keys(room_to_admin)[i]] === my_name){
				
				isAdmin = true;
				admin_room[admin_room.length] = Object.keys(room_to_admin)[i];
			}
		}

		io.sockets.to(socket.id).emit("check_is_admin", {is_admin: isAdmin, which_room: admin_room});

	});
    

    //client requests to send a private message
	socket.on('send_private_message', function(data){
		var private_in_room = data['private_in_room'];
		var private_username = data['private_username'];
		var private_message = data['private_message'];
		var private_sender = data['private_sender']

		var user_identity_in_target_room = room_to_identity[private_in_room];
		for(var i in user_identity_in_target_room){
			if(user_identity_in_target_room[i][0] === private_username){
				var target_socket_id = user_identity_in_target_room[i][1];
				io.sockets.to(target_socket_id).emit("show_private_message", {private_room_name: private_in_room, private_content: private_message, private_msg_sender: private_sender});
				break;
			}
		}

	});

    //admin requests to kick a user
	socket.on('admin_kick_user', function(data){
		var target_in_room = data['kick_in_room'];
		var target = data['kick_username'];
		

		room_to_user[target_in_room].splice(room_to_user[target_in_room].indexOf(target),1);

		var user_identity_in_target_room = room_to_identity[target_in_room];
		for(var i in user_identity_in_target_room){
			if(user_identity_in_target_room[i][0] === target){
				var target_socket_id = user_identity_in_target_room[i][1];
				
				room_to_identity[target_in_room].splice(i,1);
				io.sockets.to(target_socket_id).emit("force_to_leave", {leave_room_name: target_in_room});
				break;
			}
		}

	});
    

    //admin requests to ban a user
	socket.on('admin_ban_user', function(data){
		var target_in_room = data['ban_in_room'];
		var target = data['ban_username'];
	
		room_to_user[target_in_room].splice(room_to_user[target_in_room].indexOf(target),1);

		var user_identity_in_target_room = room_to_identity[target_in_room];
		for(var i in user_identity_in_target_room){
			if(user_identity_in_target_room[i][0] === target){
				var target_socket_id = user_identity_in_target_room[i][1];
				
				room_to_identity[target_in_room].splice(i,1);
				io.sockets.to(target_socket_id).emit("force_to_leave", {leave_room_name: target_in_room});
				break;
			}
		}
        
        var room_exist = false;
		for(var key in blacklist){
			if(key === target_in_room){
				var black_room_users = blacklist[target_in_room];
				black_room_users[black_room_users.length] = target;
				room_exist = true;
				break;
			}
		}

		if(!room_exist){
			blacklist[target_in_room] = [target];
		}

	});
    

    //check if client is in blacklist
	socket.on('isInBlackList', function(data){
		var check_room = data['check_room'];
		var check_username = data['check_username'];
		var is_banned = false;

		for(var key in blacklist){
			if(key === check_room){
				var users_to_check = blacklist[key];
				if(users_to_check.indexOf(check_username) != -1){
					is_banned = true;
					break;
				}
			}
		} 
     
		io.sockets.to(socket.id).emit('join_check', {am_i_banned: is_banned, in_room:check_room});

	});


    //find room list
	socket.on('find_rooms', function(data){
		var public_or_private = data['public_or_private'];
		if(public_or_private === 'public'){
			io.sockets.to(socket.id).emit('show_room_list', {room_list: public_rooms, room_type: "public"});

		}else{
			io.sockets.to(socket.id).emit('show_room_list', {room_list: private_rooms, room_type: "private"});
		}
	});

    //update room list
	socket.on('update_rooms', function(data){
		var public_or_private = data['public_or_private'];
		if(public_or_private === 'public'){
			io.sockets.emit('update_room_list', {room_list: public_rooms, room_type: "public"});

		}else{
			io.sockets.emit('update_room_list', {room_list: private_rooms, room_type: "private"});
		}
	});

    //admin requests to transfer admin to another user
	socket.on('transfer_admin', function(data){
		var new_admin = data['new_admin'];
		var admin_room = data['admin_room'];
		room_to_admin[admin_room] = new_admin;
	});
    

    //request to update category
	socket.on('update_category', function(data){
		io.sockets.emit('show_category', {category_room_list: categorty_to_room});
	});
	
});





