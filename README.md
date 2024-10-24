Datenbank: Rezepte 
-------------------------------------- AB HIER WIRD ALLES KLEINGESCHRIEBEN --------------------------------------

Table: user 
user_id	  vorname	  nachname	  username	  password

-----------------------------------------------------------------------------------------------------------------	

Table: rezept 
rezept_id	  titel	  ersteller_id 	  zubereitung 	  bild 	  kategorie1	  kategorie2	  zeit      	  schwierigkeit
					                	Frühstück
                                                           	Hauptspeise
                                                            	Abendessen
                                                            	Dessert 
                                                            	Snack 	
                                                                         	 Vegan
                                                                          	Vegetarisch 
                                                                          	Alles 	
                                                                                        	schnell 
                                                                                        	mittel
                                                                                        	lang 	
                                                                                                      		Leicht 
                                                                                                      		Mittel 
                                                                                                      		Schwer 
													
-----------------------------------------------------------------------------------------------------------------

Table: zutaten 
rezept_id	  zutat_id	  name	  menge 

-----------------------------------------------------------------------------------------------------------------

Falls wir noch Zeit haben: Bewertung 
bewertung_id	rezept_id	user_id	anzahlsterne	kommentar

