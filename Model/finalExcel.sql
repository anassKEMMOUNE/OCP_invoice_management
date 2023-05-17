/*Rank & site CEC & categorie & deviseFacture & type*/
SELECT C.uniteOperationelle, Fa.identifiantGED, C.service, F.nomFournisseur, Fa.blocage , 
CDP.nomCDP, E.nomEntite,Fa.cA, C.numCommande, C.montantCommande,C.montantReceptionne,Fa.montantDesFactures, 
Fa.montantMiseADisposition ,Fa.numeroFacture , Fa.montantFactureTTCDevise, C.acheteur, C.typeDAchatPO, 
Fa.intervenant,Fa.nombreDeJoursAEcheance
FROM (Fournisseur AS F) NATURAL JOIN (Commande AS C) NATURAL JOIN (ChefDeProjet AS CDP) NATURAL JOIN (Facture AS Fa) NATURAL JOIN (Entite AS E)
INTO OUTFILE 'directoryToChange'
FIELDS TERMINATED BY ','
ENCLOSED BY '"' 
LINES TERMINATED BY '\n'; 