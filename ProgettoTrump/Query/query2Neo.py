from neo4j import GraphDatabase
import time
driver=GraphDatabase.driver('bolt://localhost:7687', auth=('neo4j','12345678'))


for tempo in range(0,31):
	tempo_iniziale=time.clock()*1000
	def print_friends_of(tx, name):
		for record in tx.run("MATCH (a:Organization)-[r]-() RETURN a.name, COUNT(*) as b ORDER BY COUNT(*) DESC", name=name):
			print(record["a.name"],record["b"])
	tempo_finale=time.clock()*1000
	print(tempo_finale-tempo_iniziale)
with driver.session() as session:
    session.read_transaction(print_friends_of, "Trump")