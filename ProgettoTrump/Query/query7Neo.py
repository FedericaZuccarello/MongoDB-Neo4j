from neo4j import GraphDatabase
import time
driver=GraphDatabase.driver('bolt://localhost:7687', auth=('neo4j','12345678'))


for tempo in range(0,31):
	tempo_iniziale=time.clock()*1000
	def print_friends_of(tx, name):
		for record in tx.run("MATCH (o1:Organization {name:'TRUMP TOWER COMMERCIAL LLC'}) MATCH (o2:Organization {name:'40 WALL STREET LLC'}) MATCH path = (o1)-[*..3]-(o2) RETURN path", name=name):
			print(record["path"])
	tempo_finale=time.clock()*1000
	print(tempo_finale-tempo_iniziale)
with driver.session() as session:
    session.read_transaction(print_friends_of, "Trump")