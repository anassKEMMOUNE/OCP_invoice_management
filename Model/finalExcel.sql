/*SQL script to export DATA*/
SELECT Fa.rank_ ,C.uniteOperationelle, Fa.identifiantGED, Fa.siteCEC ,
C.service, F.nomFournisseur, Fa.blocage , 
CDP.nomCDP, E.nomEntite,Fa.cA, C.numCommande, C.montantCommande,
C.montantReceptionne,Fa.montantDesFactures, 
Fa.montantMiseADisposition ,Fa.numeroFacture , Fa.montantFactureTTCDevise, Fa.deviseFacture ,
Fa.typeF,C.acheteur, C.typeDAchatPO, 
Fa.intervenant,Fa.nombreDeJoursAEcheance,Fa.echeance
FROM (Fournisseur AS F) NATURAL JOIN (Commande AS C) NATURAL JOIN (ChefDeProjet AS CDP) 
NATURAL JOIN (Facture_View AS Fa) NATURAL JOIN (Entite AS E)
WHERE Fa.intervenant = 'SPOC' or Fa.intervenant = 'Litige' or Fa.typeF = "Intercos"
INTO OUTFILE 'directoryToChange'
FIELDS TERMINATED BY ','
ENCLOSED BY '"' 
LINES TERMINATED BY '\n'; 