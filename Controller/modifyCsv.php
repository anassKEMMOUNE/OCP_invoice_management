<?php 
$initial_names = ["RANK","Nom Unité Opérationnelle","Identifiant GED","Site CEC","Service","Fournisseur","Fournisseur R12","Code fournisseur","Site fournisseur","Type Facture","Date GL","Statut","Statut2","Context CUF","Num commande","Montant de la commande/Appel de cde","Montant des réceptions","Montant des factures","Montant mise à disposition","Date envoi à l'ordonnancement","Date transmission tréso","Numéro Facture","Date Facture","Montant Facture TTC (DEVISE)","Montant Retenu Facture","Devise Facture","Type","Taux change","Montant Facture TTC (MAD)","Date Base Échéance","Condition de paiement","Date Échéance","Echéance","Date Scan","Date création sur Share","Motif Rejet FMFI","Blocage ERP","Documents manquants","Acheteur","Demandeur de la commande","Approbateur","CB Frns sur Share","CB Frns sur entête facture R12","CB Frns sur Echéance R12","Dernier commentaire","Date dernier commentaire","Statut règlement sur R12","Date règlement sur R12","Numéro de règlement R12","Type d'achat PO","SA R12","Description SA R12","Site R12","Entité R12","Facture SHARE traitée par","ID_FACTURE_R12","ID_FACTURE_SHARE","Classe Projet","Chef de projet","Approbation 1","Approbation 2","Approbation 3","Approbation 4","Comptable","Litige","SPOC","Site","Site DI","Axe","Intervenant","Blocage","Système","Nombre de jours à l'échéance","Catégorie ancienneté","Satut"];
$final_names =  ["Rank_","UniteOperationnelle","IdentifiantGED","SiteCEC","Service","NomFournisseur","FournisseurR12","CodeFournisseur","SiteFournisseur","TypeFacture","DateGL","Statut","Statut2","ContextCUF","NumCommande","MontantCommande","montantReceptionne","MontantDesFactures","MontantMiseADisposition","DateEnvoiALOrdonnancement","DateTransmissionTreso","NumeroFacture","DateFacture","MontantFactureTTCDevise","MontantRetenuFacture","DeviseFacture","Type_","TauxChange","MontantFactureTTCMAD","DateBaseEcheance","ConditionDePaiement","DateEcheance","Echeance","DateScan","DateCreationSurShare","MotifRejetFMFI","BlocageERP","DocumentsManquants","Acheteur","DemandeurDeLaCommande","Approbateur","CBFrnsSurShare","CBFrnsSurEnteteFactureR12","CBFrnsSurEcheanceR12","DernierCommentaire","DateDernierCommentaire","StatutReglementSurR12","DateReglementSurR12","NumeroDeReglementR12","TypeDAchatPO","SAR12","DescriptionSAR12","SiteR12","EntiteR12","FactureSHARETraiteePar","IDFactureR12","IDFactureSHARE","ClasseProjet","nomCDP","Approbation1","Approbation2","Approbation3","Approbation4","Comptable","Litige","SPOC","Site","SiteDI","Axe","Intervenant","Blocage","Systeme","NombreDeJoursAEcheance","CategorieAnciennete","Satut"];
$final_names = array_map('lcfirst', $final_names);
$final_map = array_combine($initial_names,$final_names);
// Path to the CSV file
function modifyFirstLineCsv($csvPath){
global $final_map;
$fileContent = file($csvPath);
$fileContent[0]= str_replace('"','',$fileContent[0]);
$fileContent[0] = str_replace("\n","",$fileContent[0]);
$firstLineArray = explode(",",$fileContent[0]);
foreach ($firstLineArray as $key => $ele){
$firstLineArray[$key] =  $final_map[$ele];
}
$fileContent[0] = implode(",",$firstLineArray).PHP_EOL;
file_put_contents($csvPath, $fileContent);
}






?>