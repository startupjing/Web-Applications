# Simple File Sharing Site

+ link to your running ec2 instance
  - http://ec2-54-68-242-124.us-west-2.compute.amazonaws.com/share/index.html
  - (Note: the default user are jing123, yilong, wustl, jing, hello)

+ Some additional features
  - Sign up as a new user
    + Discription: There is a link in main page for new users to click and sign up as a new user, which will add the new name into our user.txt so that he or she could be validated when logging in next time and create an according folder named with the new user name for the user to upload and download files.

  - Change and update user name
    + Discription: Once successfully logging in, the user could change his or her current user name to a new one, which would accordingly update his or her existed name in user.txt and folder for uploading and downloading. After changing and updating the name, the old user name would be invalid when used to log in next time, and the associated information in the website would be updated as well.

  - Share files to existing users
    + Discription: When the user clicked the file link, he or she would see a "select list" besides each file and a "share" button. If the user wants to share a file to another existed user, he or she could select the name from the select list and click button, which would result in a copy of this file created in the shared user. (You could log in as the shared user to check if it works successfully.)

  - Search files by name and keyword
    + Discription: In order to help user to find their desired file as soon as possible, we added searching feature in our website. As a user, you could put keyword or the whole name of the file into the search field and it would offer you with all the files containing the given keywords so that you could view, delete or share them conveniently.

  - Robustness Design
    + In our file system website, we designed it to check if the user name or the file name typed by user is valid or legal. Some special tokens such as "." or  ".." would be not used as the user name or file name.
