from neo4j import GraphDatabase
import time
driver=GraphDatabase.driver('bolt://localhost:7687', auth=('neo4j','12345678'))


for tempo in range(0,31):
	tempo_iniziale=time.clock()*1000
	def print_friends_of(tx, name):
		for record in tx.run("MATCH path=(:Person {name:'DONALD J. TRUMP'})-[:RELATED_TO*1..3]-(other:Person) WHERE  ALL(x IN NODES(path) WHERE x.name <> 'IVANKA TRUMP') WITH DISTINCT(other) as other RETURN other, EXISTS( (other)-[:RELATED_TO]-(:Person{ name:'IVANKA TRUMP' }) ) as friendOfTrump ORDER BY other.name", name=name):
			print(record["other"],record["friendOfTrump"])
	tempo_finale=time.clock()*1000
	print(tempo_finale-tempo_iniziale)
with driver.session() as session:
    session.read_transaction(print_friends_of, "Trump")