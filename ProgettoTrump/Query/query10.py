import pymongo
import time

#database connection
myclient = pymongo.MongoClient("mongodb://localhost:27017/")
mydb = myclient["DataTrump"]
collection = mydb["DataSet"]

for tempo in range(0,31):
	tempo_iniziale=time.clock()*1000
	cursor = collection.find(
		{'$and':[{'Connections.name_con':'DONALD J. TRUMP'},
		{'type':'Person'},
		{'name':{'$ne':'IVANKA TRUMP'}},
		{'Connections.name_con':'IVANKA TRUMP'}
		]})

	tempo_finale=time.clock()*1000
	print(tempo_finale-tempo_iniziale)

for document in cursor:
     print(document)

