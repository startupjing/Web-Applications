import sys,os,re

# check command line arguments
if len(sys.argv) < 2:
	sys.exit("Usage: %s filename" % sys.argv[0])

# get filename
filename = sys.argv[1]

# check if file exists
if not os.path.exists(filename):
	sys.exit("Error: File '%s' not found" % sys.argv[1])

# regular expression
pattern = '(?P<name>[\w\s]+)\sbatted\s(?P<bats>\d)[\w\s]+with\s(?P<hits>\d)'

players = [];


# player class
class Player:
	def __init__(self, name, hits, bats, average):
		self.name = name
		self.hits = hits
		self.bats = bats
		self.average = average

	def compute(self):
		self.average = round(float(self.hits)/self.bats,3)

		
# search for player in list
def searchPlayer(name):
	for p in players:
		if p.name == name:
			return p
	return None

# process each record
def process(line):
	info = re.match(pattern, line)

	if info:
		name = info.group('name')
		hits = int(info.group('hits'))
		bats = int(info.group('bats'))

		p = searchPlayer(name)
		if p is None:
			newP = Player(name,hits,bats, 0)
			players.append(newP)
		else:
			p.bats += bats
			p.hits += hits
		



f = open(filename)

line = f.readline()

# parse file
while line:
	process(line)
	line = f.readline()

f.close()

# compute averge for each player
for p in players:
	p.compute()

# sort by averge from highest to lowest
sorted_players = sorted(players, key=lambda p: p.average, reverse=True)

# print result
for p in sorted_players:
	print "%s: %.3f" % (p.name,p.average)


