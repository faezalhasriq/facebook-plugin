<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/*********************************************************************************

 * Description:    Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/
global $timedate;
 
$mod_strings = array (
    'LBL_GOOD_FILE' => 'Επιτυχής Εισαγωγή Αναγνωσμένου Αρχείου',
    'LBL_RECORDS_SKIPPED_DUE_TO_ERROR' => 'γραμμές δεν εισήχθησαν, λόγω λάθους',
    'LBL_UPDATE_SUCCESSFULLY' => 'οι εγγραφές ενημερώθηκαν με επιτυχία',
    'LBL_SUCCESSFULLY_IMPORTED' => 'δημιουργήθηκαν εγγραφές',
    'LBL_STEP_4_TITLE' => 'Βήμα {0}: Εισαγωγή Αρχείου',
    'LBL_STEP_5_TITLE' => 'Βήμα {0}: Προβολή Αποτελεσμάτων Εισαγωγής',
    'LBL_CUSTOM_ENCLOSURE' => 'Προσδιορισμένα Πεδία Από:',
    'LBL_ERROR_UNABLE_TO_PUBLISH' => 'Δεν είναι δυνατή η δημοσίευση. Υπάρχει ένας άλλος δημοσιευμένος χάρτης εισαγωγών με το ίδιο όνομα.',
    'LBL_ERROR_UNABLE_TO_UNPUBLISH' => 'Ανίκανο να μη-δημοσιεύσει έναν χάρτη που ανήκει σε έναν άλλο χρήστη. Είστε κύριος ενός χάρτη εισαγωγών με το ίδιο όνομα',
    'LBL_ERROR_IMPORTS_NOT_SET_UP' => 'Οι εισαγωγές δεν έχουν συσταθεί για αυτόν τον τύπο ενότητας',
    'LBL_IMPORT_TYPE' => 'Τι θα θέλατε να κάνετε με τα δεδομένα εισαγωγής;',
    'LBL_IMPORT_BUTTON' => 'Δημιουργία μόνο νέων εγγραφών',
    'LBL_UPDATE_BUTTON' => 'Δημιουργία νέων εγγραφών και ενημερώσεις υφιστάμενων εγγραφών',
    'LBL_CREATE_BUTTON_HELP' => 'Χρησιμοποιήστε αυτή την επιλογή για να δημιουργήσετε νέες εγγραφές. Σημείωση: Οι Σειρές στο αρχείο εισαγωγής που περιέχει τις τιμές που ταιριάζουν με τις Ταυτότητες των υφιστάμενων εγγραφών δεν θα εισαχθούν εάν οι τιμές αντιστοιχίζονται στο πεδίο ταυτότητας.',
    'LBL_UPDATE_BUTTON_HELP' => 'Χρησιμοποιήστε αυτή την επιλογή για να ενημερώσετε τις υπάρχουσες εγγραφές. Τα δεδομένα στο αρχείο εισαγωγής θα πρέπει να ταιριάζου με τις υπάρχουσες εγγραφές με βάση την Ταυτότητα εγγραφής στο αρχείο εισαγωγής.',
    'LBL_NO_ID' => 'Υποχρεωτική Ταυτότητα',
    'LBL_PRE_CHECK_SKIPPED' => 'Προ-Έλεγχος Παραλείφθηκε',
    'LBL_NOLOCALE_NEEDED' => 'Δεν απαιτείται τοπική προσαρμογή',
    'LBL_FIELD_NAME' => 'Όνομα Πεδίου',
    'LBL_VALUE' => 'Αξία',
    'LBL_ROW_NUMBER' => 'Αριθμός Σειράς',
    'LBL_NONE' => 'Κανένα',
    'LBL_REQUIRED_VALUE' => 'Υποχρεωτική αξία λείπει',
    'LBL_ERROR_SYNC_USERS' => 'Άκυρη αξία για συγχρονισμό με το Outlook:',
    'LBL_ID_EXISTS_ALREADY' => 'Η Ταυτότητα υπάρχει ήδη σε συτόν τον πίνακα',
    'LBL_ASSIGNED_USER' => 'Εάν ο χρήστης δεν υπάρχει χρησιμοποιείστε τον τρέχον χρήστη',
    'LBL_SHOW_HIDDEN' => 'Εμφάνιση πεδίων που δεν είναι κανονικά εισαγώγιμοι',
    'LBL_UPDATE_RECORDS' => 'Ενημέρωση υφιστάμενων εγγραφών αντί της εισαγωγής τους (Όχι Αναίρεση)',
    'LBL_TEST'=> 'Δοκιμή εισαγωγής (μην αποθηκεύσετε και μην αλλάξετε δεδομένα)',
    'LBL_TRUNCATE_TABLE' => 'Κενός πίνακας πριν από την εισαγωγή (διαγραφή όλων των εγγραφών)',
    'LBL_RELATED_ACCOUNTS' => 'Μην δημιουργήσετε σχετικούς λογαριασμούς',
    'LBL_NO_DATECHECK' => 'Παράληψη έλεγχος ημερομηνίας (πιο γρήγορα, αλλά θα αποτύχει αν οποιαδήποτε ημερομηνία είναι λάθος)',
    'LBL_NO_WORKFLOW' => 'Μην εκτελέσετε ροή εργασίας κατά τη διάρκεια αυτής της εισαγωγής',
    'LBL_NO_EMAILS' => 'Μην στείλετε ειδοποιήσεις μέσω Email κατά τη διάρκεια αυτής της εισαγωγής',
    'LBL_NO_PRECHECK' => 'Εγγενής Μορφή Λειτουργίας',
    'LBL_STRICT_CHECKS' => 'Χρησιμοποιήστε αυστηρά το σύνολο κανόνων (Ελέγξτε τις διευθύνσεις Email και τους αριθμούς τηλεφώνου επίσης)',
    'LBL_ERROR_SELECTING_RECORD' => 'Λάθος επιλογή εγγραφής:',
    'LBL_ERROR_DELETING_RECORD' => 'Λάθος κατά τη διαγραφή εγγραφής:',
    'LBL_NOT_SET_UP' => 'Εισαγωγή δεν έχει συσταθεί για αυτόν τον τύπο ενότητας',
    'LBL_ARE_YOU_SURE' => 'Είστε βέβαιοι; Αυτό θα διαγράψει όλα τα δεδομένα σε αυτή την ενότητα.',
    'LBL_NO_RECORD' => 'Καμία εγγραφή με αυτόν την Ταυτότητα για ενημέρωση',
    'LBL_NOT_SET_UP_FOR_IMPORTS' => 'Εισαγωγή δεν έχει συσταθεί για αυτόν τον τύπο ενότητας',
    'LBL_DEBUG_MODE' => 'Ενεργοποίηση της λειτουργίας αποσφαλμάτωσης',
    'LBL_ERROR_INVALID_ID' => 'Η Ταυτότητα που δώσατε είναι πάρα πολύ μεγάλη για να χωρέσει στο πεδίο (το μέγιστο μήκος είναι 36 χαρακτήρες)',
    'LBL_ERROR_INVALID_PHONE' => 'Άκυρος αριθμός τηλεφώνου',
    'LBL_ERROR_INVALID_NAME' => 'Η Συμβολοσειρά είναι πάρα πολύ μεγάλη για να χωρέσει στο πεδίο',
    'LBL_ERROR_INVALID_VARCHAR' => 'Η Συμβολοσειρά είναι πάρα πολύ μεγάλη για να χωρέσει στο πεδίο',
    'LBL_ERROR_INVALID_DATETIME' => 'Άκυρη ημερομηνία ώρα',
    'LBL_ERROR_INVALID_DATETIMECOMBO' => 'Άκυρη ημερομηνία ώρα',
    'LBL_ERROR_INVALID_INT' => 'Άκυρη ακέραια τιμή',
    'LBL_ERROR_INVALID_NUM' => 'Άκυρη αριθμητική τιμή',
    'LBL_ERROR_INVALID_TIME' => 'Άκυρη ώρα',
    'LBL_ERROR_INVALID_EMAIL'=>'Άκυρη διεύθυνση Email',
    'LBL_ERROR_INVALID_BOOL'=>'Άκυρη αξία (πρέπει να είναι 1 ή 0)',
    'LBL_ERROR_INVALID_DATE'=>'Άκυρη συμβολοσειρά ημερομηνίας',
    'LBL_ERROR_INVALID_USER'=>'Άκυρο όνομα χρήστη ή Ταυτότητα',
    'LBL_ERROR_INVALID_TEAM' => 'Άκυρο όνομα ομάδας ή Ταυτότητα',
    'LBL_ERROR_INVALID_ACCOUNT' => 'Άκυρο όνομα λογαριασμού ή Ταυτότητα',
    'LBL_ERROR_INVALID_RELATE' => 'Άκυρο σχετικό πεδίο',
    'LBL_ERROR_INVALID_CURRENCY' => 'Άκυρη αξία νομίσματος',
    'LBL_ERROR_INVALID_FLOAT' => 'Άκυρος αριθμός κινητής υποδιαστολής',
    'LBL_ERROR_NOT_IN_ENUM' => 'Αξία όχι σε αναπτυσσόμενη λίστα. Επιτρεπόμενες τιμές είναι οι εξής:',
    'LBL_ERROR_ENUM_EMPTY' => 'Η τιμή δεν εμφανίζεται στην αναπτυσσόμενη λίστα. Η αναπτυσσόμενη λίστα είναι κενή',
    'LBL_NOT_MULTIENUM' => 'Όχι MultiEnum',
    'LBL_IMPORT_MODULE_NO_TYPE' => 'Εισαγωγή δεν έχει συσταθεί για αυτόν τον τύπο ενότητας',
    'LBL_IMPORT_MODULE_NO_USERS' => 'ΠΡΟΣΟΧΗ: Δεν υπάρχουν χρήστες που ορίζονται στο σύστημά σας. Εάν εισαγάγετε χωρίς να προσθέσετε πρώτα τους χρήστες, όλες οι εγγραφές θα ανήκουν από τον Διαχειριστή.',
    'LBL_IMPORT_MODULE_MAP_ERROR' => 'Δεν είναι δυνατή η δημοσίευση. Υπάρχει ένας άλλος δημοσιευμένος χάρτης εισαγωγών από το ίδιο όνομα.',
    'LBL_IMPORT_MODULE_MAP_ERROR2' => 'Ανίκανο να επανα-δημοσιεύσει έναν χάρτη που ανήκει σε έναν άλλο χρήστη. Είστε κάτοχος ενός χάρτη εισαγωγών από το ίδιο όνομα.',
    'LBL_IMPORT_MODULE_NO_DIRECTORY' => 'Ο κατάλογος',
    'LBL_IMPORT_MODULE_NO_DIRECTORY_END' => 'δεν υπάρχει ή δεν είναι εγγράψιμος',
    'LBL_IMPORT_MODULE_ERROR_NO_UPLOAD' => 'Το αρχείο δεν φορτώθηκε επιτυχώς. Μπορεί η ρύθμιση του φορτωμένου_μέγιστου_μέγεθος αρχείων στο php.ini αρχείο σας να έχει ρυθμιστεί σε ένα μικρό αριθμό',
    'LBL_IMPORT_MODULE_ERROR_LARGE_FILE' => 'Το αρχείο είναι πολύ μεγάλο. Μέγιστο:',
    'LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END' => 'Bytes. Change $sugar_config[&#39;upload_maxsize&#39;] in config.php',
    'LBL_MODULE_NAME' => 'Εισαγωγή',
    'LBL_MODULE_NAME_SINGULAR' => 'Εισαγωγή',
    'LBL_TRY_AGAIN' => 'Δοκιμάστε Ξανά',
    'LBL_START_OVER' => 'Ξεκινήστε Πάνω',
    'LBL_ERROR' => 'Λάθος:',
    'LBL_IMPORT_ERROR_MAX_REC_LIMIT_REACHED' => 'Το αρχείο εισαγωγής περιέχει {0} σειρές. Ο βέλτιστος αριθμός των σειρών είναι {1}. Περισσότερες σειρές μπορεί να επιβραδύνει τη διαδικασία εισαγωγής. Πατήστε Εντάξει να συνεχίσετε την εισαγωγή. Πατήστε Ακύρωση για να αναθεωρήσει και να επαν-φορτώσει το αρχείο εισαγωγών.',
    'ERR_IMPORT_SYSTEM_ADMININSTRATOR'  => 'Δεν μπορείτε να εισαγάγετε έναν χρήστη διαχείρισης του συστήματος',
    'ERR_REPORT_LOOP' => 'Το σύστημα ανίχνευσε έναν βρόχο υποβολής αναφορών. Ο χρήστης δεν μπορεί να δώσει αναφορά στον ευατό του, ούτε μπορούν οποιοιδήποτε από τους διαχειριστές τους να υποβάλουν αναφορά σε αυτούς.',
    'ERR_MULTIPLE' => 'Πολλαπλές στήλες έχουν οριστεί με το ίδιο όνομα του πεδίου.',
    'ERR_MISSING_REQUIRED_FIELDS' => 'Λείπει υποχρεωτικό πεδίο:',
    'ERR_MISSING_MAP_NAME' => 'Λείπει προσαρμοσμένο όνομα χαρτογράφησης',
    'ERR_SELECT_FULL_NAME' => 'Δεν μπορείτε να επιλέξετε το Πλήρες Όνομα όταν το Όνομα και το Επώνυμο επιλέγονται.',
    'ERR_SELECT_FILE' => 'Επιλέξτε ένα αρχείο για να φορτώσετε.',
    'LBL_SELECT_FILE' => 'Επιλογή Αρχείου:',
    'LBL_CUSTOM' => 'Προσαρμοσμένο',
    'LBL_CUSTOM_CSV' => 'Προσαρμοσμένο αρχείο οριοθετημένο με κόμματα',
    'LBL_CSV' => 'ένα αρχείο στον υπολογιστή μου',
    'LBL_EXTERNAL_SOURCE' => 'μια εξωτερική εφαρμογή ή υπηρεσία',
    'LBL_TAB' => 'Καρτέλα οριοθετημένου αρχείου',
    'LBL_CUSTOM_DELIMITED' => 'Προσαρμοσμένο οριοθετημένο αρχείο',
    'LBL_CUSTOM_DELIMITER' => 'Οριοθετημένα Πεδία Από:',
    'LBL_FILE_OPTIONS' => 'Επιλογές αρχείου',
    'LBL_CUSTOM_TAB' => 'Προσαρμοσμένη καρτέλα αρχείου',
    'LBL_DONT_MAP' => '--Μην χαρτογραφήσετε αυτό το πεδίο--',
    'LBL_STEP_MODULE' => 'Ποια ενότητα θέλετε για να εισαγάγει δεδομένα;',
    'LBL_STEP_1_TITLE' => 'Βήμα 1: Επιλογή Πηγής Δεδομένων',
    'LBL_CONFIRM_TITLE' => 'Βήμα {0}: Επιβεβαίωση Ιδιοτήτων των Αρχείων Εισαγωγών',
    'LBL_CONFIRM_EXT_TITLE' => 'Βήμα {0}: Επιβεβαίωση Ιδιοτήτων της Εξωτερικές  Πηγής',
    'LBL_WHAT_IS' => 'Τα δεδομένα μου είναι σε:',
    'LBL_MICROSOFT_OUTLOOK' => 'Microsoft Outlook',
    'LBL_MICROSOFT_OUTLOOK_HELP' => 'Οι προσαρμοσμένες χαρτογραφήσεις για το Microsoft Outlook βασίζονται στο αρχείο εισαγωγής που είναι οριοθετημένο με κόμμα (.csv). Εάν το αρχείο εισαγωγής σας είναι οριοθετημένο με tab, οι χαρτογραφήσεις δεν θα εφαρμοστούν όπως αναμενόταν.',
    'LBL_ACT' => 'Δράση!',
    'LBL_SALESFORCE' => 'Salesforce.com',
    'LBL_MY_SAVED' => 'Για να χρησιμοποιήσετε τις αποθηκευμένες ρυθμίσεις εισαγωγή σας, επιλέξτε από τα παρακάτω:',
    'LBL_PUBLISH' => 'Δημοσίευση',
    'LBL_DELETE' => 'Διαγραφή',
    'LBL_PUBLISHED_SOURCES' => 'Για να χρησιμοποιήσετε τις προ-καθορισμένες ρυθμίσεις εισαγωγών, επιλέξτε από παρακάτω:',
    'LBL_UNPUBLISH' => 'Μη-Δημοσίευση',
    'LBL_NEXT' => 'Επόμενο >',
    'LBL_BACK' => '< Προηγούμενο',
    'LBL_STEP_2_TITLE' => 'Βήμα {0}: Λήψη Αρχείου Εισαγωγής',
    'LBL_HAS_HEADER' => 'Σειρά Επικεφαλίδας:',
    'LBL_NUM_1' => '1.',
    'LBL_NUM_2' => '2.',
    'LBL_NUM_3' => '3.',
    'LBL_NUM_4' => '4.',
    'LBL_NUM_5' => '5.',
    'LBL_NUM_6' => '6.',
    'LBL_NUM_7' => '7.',
    'LBL_NUM_8' => '8.',
    'LBL_NUM_9' => '9.',
    'LBL_NUM_10' => '10.',
    'LBL_NUM_11' => '11.',
    'LBL_NUM_12' => '12.',
    'LBL_NOTES' => 'Σημειώσεις:',
    'LBL_NOW_CHOOSE' => 'Τώρα επιλέξτε το αρχείο για εισαγωγή:',
    'LBL_IMPORT_OUTLOOK_TITLE' => 'Το Microsoft Outlook 98 και 2000 μπορεί να εξαγάγει δεδομένα <b>Αξιών Διαχωρισμένες με Κόμμα</b> μορφή, όπου μπορεί να χρησιμοποιηθεί για να εισαγάγει τα δεδομένα στο σύστημα. Για την εξαγωγή των δεδομένων σας από το Outlook, ακολουθήστε τα παρακάτω βήματα:',
    'LBL_OUTLOOK_NUM_1' => 'Ξεκινήστε Outlook',
    'LBL_OUTLOOK_NUM_2' => 'Επιλέξτε το μενού Αρχείο, στη συνέχεια Εισαγωγή και Εξαγωγή ...επιλογή μενού',
    'LBL_OUTLOOK_NUM_3' => 'Επιλέξτε Εξαγωγή σε αρχείο και πατήστε στο κουμπί Επόμενο',
    'LBL_OUTLOOK_NUM_4' => 'Επιλέξτε <b>Αξίες Διαχωρισμένες με Κόμμα (Windows)</b> και πατήστε το κουμπί <b>Επόμενο</b>.<br>    Σημείωση: Μπορεί να σας ζητηθεί να εγκαταστήσετε το στοιχείο των εξαγωγών',
    'LBL_OUTLOOK_NUM_5' => 'Επιλέξτε τον φάκελο Επαφών και πατήστε το κουμπί Επόμενο. Μπορείτε να επιλέξετε διαφορετικούς φακέλους επαφών εάν οι επαφές σας είναι αποθηκευμένες σε πολλούς φακέλους',
    'LBL_OUTLOOK_NUM_6' => 'Επιλέξτε ένα όνομα αρχείου και πατήστε <b>Επόμενο</b>',
    'LBL_OUTLOOK_NUM_7' => 'Πατήστε <b>Τέλος</b>',
    'LBL_IMPORT_SF_TITLE' => 'Το Salesforce.com μπορεί να εξαγάγει δεδομένα σε <b>Αξίες Διαχωριστικές με Κόμμα</b> μορφή, που μπορεί να χρησιμοποιηθεί για την εισαγωγή δεδομένων στο σύστημα. Για να εξαγάγετε τα δεδομένα σας από το Salesforce.com, ακολουθήστε τα παρακάτω βήματα:',
    'LBL_SF_NUM_1' => 'Ανοίξτε το πρόγραμμα περιήγησής σας, πηγαίνετε στο http://www.salesforce.com, και συνδεθείτε με τη διεύθυνση email και τον κωδικό σας',
    'LBL_SF_NUM_2' => 'Πατήστε στην καρτέλα Αναφορές στο επάνω μενού',
    'LBL_SF_NUM_3' => '<b>Εξαγωγή Λογαριασμών:</b> Πατήστε στον σύνδεσμο <b>Ενεργοί Λογαριασμοί</b> <br><b>Εξαγωγή Επαφών export Contacts:</b> Πατήστε στον σύνδεσμο <b>Λίστα Αλληλογραφίας</b>',
    'LBL_SF_NUM_4' => 'Στο<b>Βήμα 1: Επιλέξτε τον τύπο αναφοράς σας</b>, επιλέξτε <b>Αναφορά Πίνακα</b> πατήστε  <b>Επόμενο</b>',
    'LBL_SF_NUM_5' => 'Στο <b>Βήμα 2: Επιλέξτε τις στήλες αναφορών</b>, επιλέξτε τις στήλες που θέλετε να εξάγετε και πατήστε <b>Επόμενο</b>',
    'LBL_SF_NUM_6' => 'Στο <b>Βήμα 3: Επιλέξτε την πληροφορία για να συνοψίσει </b>, απλά πατήστε <b>Επόμενο</b>',
    'LBL_SF_NUM_7' => 'Στο <b>Βήμα 4: Διατάξτε τις στήλες αναφορών</b>, απλά πατήστε <b>Επόμενο</b>',
    'LBL_SF_NUM_8' => 'Στο <b>Βήμα 5: Επιλέξτε τα κριτήρια αναφοράς</b>, πάνω <b>Ημερομηνία Έναρξης</b>, επιλέξτε μια ημερομηνία αρκετά μακριά στο παρελθόν για να περιλάβετε όλους τους Λογαριασμούς σας. Μπορείτε επίσης να εξαγάγετε ένα υποσύνολο των Λογαριασμών χρησιμοποιώντας τα πιο προηγμένα κριτήρια. Όταν ολοκληρώσετε, πατήστε <b>Εκτέλεση Αναφοράς</b>',
    'LBL_SF_NUM_9' => 'Η αναφορά θα παράγεται, και η σελίδα θα εμφανίσει <b>Κατάσταση Παραγωγής Αναφορών: Οοκλήρωση.</b> Τώρα πατήστε <b>Εξαγωγή σε Excel</b>',
    'LBL_SF_NUM_10' => '<b>Εξαγωγή Αναφορών:</b>, για <b>Εξαγωγή Μορφής Αρχείου:</b>, επιλέξτε <b>Οριοθετημένο με κόμμα .csv</b>. Πατήστε <b>Εξαγωγή</b>.',
    'LBL_SF_NUM_11' => 'Ένα πλαίσιο διαλόγου θα εμφανιστεί για να αποθηκεύσετε το αρχείο εξαγωγής στον υπολογιστή σας.',
    'LBL_IMPORT_ACT_TITLE' => 'Πράξη! μπορεί να εξαγάγει στις <b>Αξίες Διαχωρισμένες με Κόμμα</b> μορφή, που μπορεί να χρησιμοποιηθεί για να εισαγάγει τα δεδομένα στο σύστημα. Για εξαγωγή των δεδομένων από Πράξη!, ακολουθήστε τα παρακάτω βήματα:',
    'LBL_ACT_NUM_1' => '<b>ΠΡΑΞΗ!</b>',
    'LBL_ACT_NUM_2' => 'Επιλέξτε από το μενού <b>Αρχείο</b>, την επιλογή <b>Ανταλλαγή Δεδομένων</b>, έπειτα την <b>Εξαγωγή...</b> επιλογή μενού',
    'LBL_ACT_NUM_3' => 'Επιλέξτε τον τύπο αρχείου <b>Κείμενο-Οριοθετημένο</b>',
    'LBL_ACT_NUM_4' => 'Επιλέξτε ένα όνομα αρχείου και μια θέση για τα εξαγόμενα δεδομένα και πατήστε <b>Επόμενο</b>',
    'LBL_ACT_NUM_5' => 'Επιλέξτε <b>Εγγραφές Επαφών μόνο</b>',
    'LBL_ACT_NUM_6' => 'Πατήστε το κουμπί <b>Επιλογές...</b>',
    'LBL_ACT_NUM_7' => 'Επιλέξτε <b>Κόμμα</b> ως τον διαχωριστικό χαρακτήρα πεδίου',
    'LBL_ACT_NUM_8' => 'Επιλέξτε το κουτάκι <b>Ναι, εξαγωγή πεδίων ονομάτων</b> και πατήστε <b>Εντάξει</b>',
    'LBL_ACT_NUM_9' => 'Πατήστε <b>Επόμενο</b>',
    'LBL_ACT_NUM_10' => 'Επιλέξτε <b>Όλες οι Εγγραφές</b> και μετά πατήστε <b>Τέλος</b>',
    'LBL_IMPORT_CUSTOM_TITLE' => 'Πολλές εφαρμογές σας επιτρέπουν να εξαγάγετε τα δεδομένα σε ένα  <b>Οριοθετημένο με Κόμμα αρχείο κειμένου (.csv)</b> ακολουθώντας αυτά τα γενικά βήματα:',
    'LBL_CUSTOM_NUM_1' => 'Ξεκινήστε την εφαρμογή και ανοίξτε το αρχείο δεδομένων',
    'LBL_CUSTOM_NUM_2' => 'Επιλέξτε την <b>Αποθήκευση Ως...</b> ή <b>Εξαγωγή...</b> επιλογή μενού',
    'LBL_CUSTOM_NUM_3' => 'Αποθήκευση αυτού του αρχείου σε <b>CSV</b> ή <b>Αξίες Διαχωρισμένες με Κόμμα</b> μορφή',
    'LBL_IMPORT_TAB_TITLE' => 'Πολλές εφαρμογές σας επιτρέπουν να εξαγάγετε τα δεδομένα σε ένα  <b>Οριοθετημένο με Tab αρχείο κειμένου (.tsv ή .tab) </b> ακολουθώντας αυτά τα γενικά βήματα:',
    'LBL_TAB_NUM_1' => 'Ξεκινήστε την εφαρμογή και ανοίξτε το αρχείο δεδομένων',
    'LBL_TAB_NUM_2' => 'Επιλέξτε την <b>Αποθήκευση Ως...</b> ή <b>Εξαγωγή...</b> επιλογή μενού',
    'LBL_TAB_NUM_3' => 'Αποθήκευση αυτού του αρχείου σε <b>TSV</b> ή μορφή <b>Αξίες Διαχωρισμένες με Ετικέτα</b>',
    'LBL_STEP_3_TITLE' => 'Βήμα {0}: Επιβεβαίωση Χαρτογράφησης Πεδίου',
    'LBL_STEP_DUP_TITLE' => 'Βήμα {0}: Ελέγξτε για Πιθανές Αντίγραφα',
    'LBL_SELECT_FIELDS_TO_MAP' => 'Στην παρακάτω λίστα, επιλέξτε τα πεδία στο αρχείο εισαγωγής που θα πρέπει να εισάγονται σε κάθε πεδίο στο σύστημα. Όταν τελειώσετε, πατήστε <b>Επόμενο</b>:',
    'LBL_DATABASE_FIELD' => 'Πεδίο Ενότητας',
    'LBL_HEADER_ROW' => 'Σειρά Επικεφαλίδας',
    'LBL_HEADER_ROW_OPTION_HELP' => 'Επιλέξτε αν η πρώτη σειρά του αρχείου εισαγωγής είναι μια Σειρά Επικεφαλίδας που περιέχει τις ετικέτες πεδίου.',
    'LBL_ROW' => 'Σειρά',
    'LBL_SAVE_AS_CUSTOM' => 'Αποθήκευση ως Προσαρμοσμένη Χαρτογράφηση:',
    'LBL_SAVE_AS_CUSTOM_NAME' => 'Προσαρμοσμένο Όνομα Χαρτογράφησης:',
    'LBL_CONTACTS_NOTE_1' => 'Είτε το Επώνυμο ή το Ονοματεπώνυμο πρέπει να χαρτογραφηθούν.',
    'LBL_CONTACTS_NOTE_2' => 'Αν το Ονοματεπώνυμο χαρτογραφείται, τότε το Όνομα και το Επώνυμο αγνοούνται.',
    'LBL_CONTACTS_NOTE_3' => 'Αν το Ονοματεπώνυμο χαρτογραφείται, τότε τα δεδομένα στο Ονοματεπώνυμο θα χωριστούν σε Όνομα και Επώνυμο όταν εισάγονται στη βάση δεδομένων.',
    'LBL_CONTACTS_NOTE_4' => 'Τα πεδία που λήγουν σε Διεύθυνση, Οδός 2 και σε Διεύθυνση, Οδός 3 συνδέονται μαζί με το κύριο Πεδίο Διεύθυνση, Οδός όταν εισάγονται στη βάση δεδομένων.',
    'LBL_ACCOUNTS_NOTE_1' => 'Τα πεδία που λήγουν σε Διεύθυνση, Οδός 2 και σε Διεύθυνση, Οδός 3 συνδέονται μαζί με το κύριο Πεδίο Διεύθυνση, Οδός όταν εισάγονται στη βάση δεδομένων.',
    'LBL_REQUIRED_NOTE' => 'Υποχρεωτικό Πεδίο(α):',
    'LBL_IMPORT_NOW' => 'Εισαγωγή Τώρα',
    'LBL_' => ' ',
    'LBL_CANNOT_OPEN' => 'Δεν μπορεί να ανοίξει το εισαγόμενο αρχείο για την ανάγνωση',
    'LBL_NOT_SAME_NUMBER' => 'Δεν ήταν ίδιος ο αριθμός πεδίων ανά γραμμή στο αρχείο σας',
    'LBL_NO_LINES' => 'Δεν ανιχνεύθηκαν σειρές στο αρχείο εισαγωγής σας. Παρακαλούμε βεβαιωθείτε ότι δεν υπάρχουν κενές σειρές στο αρχείο σας και προσπαθήστε ξανά.',
    'LBL_FILE_ALREADY_BEEN_OR' => 'Το αρχείο εισαγωγής έχει ήδη υποστεί επεξεργασία ή δεν υπάρχει',
    'LBL_SUCCESS' => 'Επιτυχία:',
	'LBL_FAILURE' => 'Εισαγωγή Απέτυχε:',
    'LBL_SUCCESSFULLY' => 'Επιτυχής Εισαγωγή',
    'LBL_LAST_IMPORT_UNDONE' => 'Η εισαγωγή δεν ολοκληρώθηκε',
    'LBL_NO_IMPORT_TO_UNDO' => 'Δεν υπήρξε καμία εισαγωγή για να αναιρέσετε.',
    'LBL_FAIL' => 'Αποτυχία:',
    'LBL_RECORDS_SKIPPED' => 'Οι εγγραφές παραλείφθηκαν επειδή λείπουν ένα ή περισσότερα απαιτούμενα πεδία',
    'LBL_IDS_EXISTED_OR_LONGER' => 'Οι εγγραφές παραλείφθηκαν επειδή οι ταυτότητες είτε υπήρχαν είτε ήταν μεγαλύτερες από 36 χαρακτήρες',
    'LBL_RESULTS' => 'Αποτελέσματα',
    'LBL_CREATED_TAB' => 'Δημιουργήθηκαν Εγγραφές',
    'LBL_DUPLICATE_TAB' => 'Αντίγραφα',
    'LBL_ERROR_TAB' => 'Λάθη',
    'LBL_IMPORT_MORE' => 'Εισαγωγή Ξανά',
    'LBL_FINISHED' => 'Ολοκληρώθηκε',
    'LBL_UNDO_LAST_IMPORT' => 'Αναίρεση εισαγωγής',
    'LBL_LAST_IMPORTED'=>'Δημιουργήθηκε',
    'ERR_MULTIPLE_PARENTS' => 'Μπορείτε μόνο να καθορίσετε μια Γονική Ταυτότητα',
    'LBL_DUPLICATES' => 'Βρέθηκαν Αντίγραφα',
    'LNK_DUPLICATE_LIST' => 'Λήψη λίστας αντιγράφων',
    'LNK_ERROR_LIST' => 'Λήψη λίστας λαθών',
    'LNK_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Λήψη λίστας των σειρών που δεν έχουν εισαχθεί',
    'LBL_UNIQUE_INDEX' => 'Επιλέξτε ευρετήριο για διπλή σύγκριση',
    'LBL_VERIFY_DUPS' => 'Για να ελέγξετε για τα υφιστάμενα δεδομένα εγγραφών που ταιριάζουν στο αρχείο εισαγωγής, επιλέξτε τα πεδία για έλεγχο.',
    'LBL_INDEX_USED' => 'Πεδία για Έλεγχο:',
    'LBL_INDEX_NOT_USED' => 'Διαθέσιμα Πεδία:',
    'LBL_IMPORT_MODULE_ERROR_NO_MOVE' => 'Το αρχείο δεν έχει φορτωθεί επιτυχώς. Ελέγξτε τα δικαιώματα αρχείου στον κατάλογο cache της εγκατάστασης του Sugar.',
    'LBL_IMPORT_FIELDDEF_ID' => 'Μοναδικός αριθμός Ταυτότητας',
    'LBL_IMPORT_FIELDDEF_RELATE' => 'Όνομα ή Ταυτότητα',
    'LBL_IMPORT_FIELDDEF_PHONE' => 'Αριθμός Τηλεφώνου',
    'LBL_IMPORT_FIELDDEF_TEAM_LIST' => 'Όνομα Ομάδας ή Ταυτότητα',
    'LBL_IMPORT_FIELDDEF_NAME' => 'Οποιοδήποτε Κείμενο',
    'LBL_IMPORT_FIELDDEF_VARCHAR' => 'Οποιοδήποτε Κείμενο',
    'LBL_IMPORT_FIELDDEF_TEXT' => 'Οποιοδήποτε Κείμενο',
    'LBL_IMPORT_FIELDDEF_TIME' => 'Ώρα',
    'LBL_IMPORT_FIELDDEF_DATE' => 'Ημερομηνία',
    'LBL_IMPORT_FIELDDEF_DATETIME' => 'Ημερομηνία Ώρα',
    'LBL_IMPORT_FIELDDEF_ASSIGNED_USER_NAME' => 'Όνομα Χειριστή ή Ταυτότητα',
    'LBL_IMPORT_FIELDDEF_BOOL' => '&#39;0&#39; ή &#39;1&#39;',
    'LBL_IMPORT_FIELDDEF_ENUM' => 'Λίστα',
    'LBL_IMPORT_FIELDDEF_EMAIL' => 'Διεύθυνση EMail',
    'LBL_IMPORT_FIELDDEF_INT' => 'Αριθμητικό (Χωρίς Δεκαδικά)',
    'LBL_IMPORT_FIELDDEF_DOUBLE' => 'Αριθμητικό (Χωρίς Δεκαδικά)',
    'LBL_IMPORT_FIELDDEF_NUM' => 'Αριθμητικό (Χωρίς Δεκαδικά)',
    'LBL_IMPORT_FIELDDEF_CURRENCY' => 'Αριθμητικό (Επιτρέπονται Δεκαδικά)',
    'LBL_IMPORT_FIELDDEF_FLOAT' => 'Αριθμητικό (Επιτρέπονται Δεκαδικά)',
    'LBL_DATE_FORMAT' => 'Μορφή Ημερομηνίας:',
    'LBL_TIME_FORMAT' => 'Μορφή Ώρας:',
    'LBL_TIMEZONE' => 'Τρέχουσα Ώρα:',
    'LBL_ADD_ROW' => 'Προσθήκη Πεδίου',
    'LBL_REMOVE_ROW' => 'Αφαίρεση Πεδίου',
    'LBL_DEFAULT_VALUE' => 'Προκαθορισμένη Αξία',
    'LBL_SHOW_ADVANCED_OPTIONS' => 'Εμφάνιση Ιδιοτήτων Εισαγωγής Αρχείου',
    'LBL_HIDE_ADVANCED_OPTIONS' => 'Απόκρυψη Ιδιοτήτων Εισαγωγής Αρχείου',
    'LBL_SHOW_NOTES' => 'Προβολή Σημειώσεων',
    'LBL_HIDE_NOTES' => 'Απόκρυψη Σημειώσεων',
    'LBL_SHOW_PREVIEW_COLUMNS' => 'Εμφάνιση Προηγούμενων Στηλών',
    'LBL_HIDE_PREVIEW_COLUMNS' => 'Απόκρυψη Προηγούμενων Στηλών',
    'LBL_SAVE_MAPPING_AS' => 'Για να αποθηκεύσετε τις ρυθμίσεις εισαγωγής, δώστε ένα όνομα για τις αποθηκευμένες ρυθμίσεις:',
    'LBL_OPTION_ENCLOSURE_QUOTE' => 'Ενιαίο Εισαγωγικό (&#39;)',
    'LBL_OPTION_ENCLOSURE_DOUBLEQUOTE' => 'Διπλό Εισαγωγικό (")',
    'LBL_OPTION_ENCLOSURE_NONE' => 'Κανένα',
    'LBL_OPTION_ENCLOSURE_OTHER' => 'Άλλο:',
    'LBL_IMPORT_COMPLETE' => 'Έξοδος',
    'LBL_IMPORT_COMPLETED' => 'Εισαγωγή Ολοκληρώθηκε',
    'LBL_IMPORT_ERROR' => 'Προέκυψαν Λάθη Κατά την Εισαγωγή',
    'LBL_IMPORT_RECORDS' => 'Εισαγωγή Εγγραφών',
    'LBL_IMPORT_RECORDS_OF' => 'από',
    'LBL_IMPORT_RECORDS_TO' => 'σε',
    'LBL_CURRENCY' => 'Νόμισμα:',
    'LBL_SYSTEM_SIG_DIGITS' => 'Σημαντικά Ψηφία Συστήματος',
    'LBL_NUMBER_GROUPING_SEP' => '1000ς διαχωριστικό:',
    'LBL_DECIMAL_SEP' => 'Υποδιαστολή:',
    'LBL_LOCALE_DEFAULT_NAME_FORMAT' => 'Μορφή Εμφάνισης Ονόματος',
    'LBL_LOCALE_EXAMPLE_NAME_FORMAT' => 'Παράδειγμα',
    'LBL_LOCALE_NAME_FORMAT_DESC' => '"χ" Χαιρετισμός "ό" Όνομα "ε" Επώνυμο',
    'LBL_CHARSET' => 'Κωδικοποίηση Αρχείου',
    'LBL_MY_SAVED_HELP' => 'Χρησιμοποιήστε αυτήν την επιλογή να εφαρμοστούν οι προ-καθορισμένες ρυθμίσεις εισαγωγών σας, συμπεριλαμβανομένων των ιδιοτήτων εισαγωγών, χαρτογραφήσεις, και οποιεσδήποτε διπλές ρυθμίσεις ελέγχου, σε αυτήν την εισαγωγή.<br><br>Πατήστε <b>Διαγραφή</b> για να διαγράψετε τις χαρτογραφήσεις για όλους τους χρήστες.',
    'LBL_MY_SAVED_ADMIN_HELP' => 'Χρησιμοποιήστε αυτήν την επιλογή να εφαρμοστούν οι προ-καρορισμένες ρυθμίσεις εισαγωγών σας, συμπεριλαμβανομένων των ιδιοτήτων εισαγωγών, χαρτογραφήσεις, και οποιεσδήποτε διπλότυπες ρυθμίσεις ελέγχου, σε αυτήν την εισαγωγή.<br><br>Πατήστε <b>Δημοσίευση</b> για να καταστήσετε τη χαρτογράφηση διαθέσιμη σε άλλουςχειριστές.<br>Πατήστε <b>Μη-Δημοσίευση</b> για να καταστήσετε τη χαρτογράφηση μη-διαθέσιμη σε άλλουςχειριστές.<br>Πατήστε <b>Διαγραφή</b> για διαγραφή της χαρτογράφησης για όλους τους χρήστες.',
    'LBL_MY_PUBLISHED_HELP' => 'Χρησιμοποιήστε αυτήν την επιλογή να εφαρμοστούν οι προ-καθορισμένες ρυθμίσεις εισαγωγών, συμπεριλαμβανομένων των ιδιοτήτων εισαγωγών, χαρτογραφήσεις, και οποιεσδήποτε διπλές ρυθμίσεις ελέγχου, σε αυτήν την εισαγωγή.',
    'LBL_ENCLOSURE_HELP' => '<p>Ο<b>χαρακτήρας του χαρακτηριστή</b> χρησιμοποιείται για να εσωκλείει το προοριζόμενο περιεχόμενο των πεδίων, συμπεριλαμβανομένων οποιωνδήποτε χαρακτήρων που χρησιμοποιούνται ως οριοθέτες.<br><br>Παράδειγμα: Αν ο οριοθέτης είναι ένα κόμμα (,) και ο χαρακτηριστής είναι ένα εισαγωγικό ("),<br><b>"Cupertino, California"</b>εισάγεται σε ένα πεδίο στην εφαρμογή και εμφανίζεται ως <b>Cupertino, California</b>.<br>Εάν δεν υπάρχουν χαρακτήρες χαρακτηριστή, ή εάν ο χαρακτήρας είναι ο χαρακτηριστής,<br><b>"Cupertino, California"</b>εισάγεται σε δύο παρακείμενα πεδία όπως <b>"Cupertino</b> και <b>"California"</b>.<br><br>Σημείωση: Το αρχείο εισαγωγής δεν μπορεί να περιέχει χαρακτήρες χαρακτηριστή.<br>Ο προεπιλεγμένος χαρακτήρας χαρακτηριστή για κόμμα- και tab- οριοθετημένα αρχεία που δημιουργήθηκαν στο Excel είναι ένα εισαγωγικό.</p>',
    'LBL_DELIMITER_COMMA_HELP' => 'Χρησιμοποιήστε αυτή την επιλογή για να επιλέξετε και να ανεβάσετε ένα αρχείο υπολογιστικού φύλλου που περιέχει τα δεδομένα που θέλετε να εισαγάγετε.Παραδείγματα: οριοθετημένο με κόμμα αρχείο .csv ή εξαγωγή αρχείου από το Microsoft Outlook.',
    'LBL_DELIMITER_TAB_HELP' => 'Επιλέξτε αυτήν την επιλογή αν ο χαρακτήρας που διαχωρίζει τα πεδία στο αρχείο εισαγωγής είναι ένα <b>TAB</b>, και η επέκταση του αρχείου είναι .txt.',
    'LBL_DELIMITER_CUSTOM_HELP' => 'Επιλέξτε αυτήν την επιλογή αν ο χαρακτήρας που διαχωρίζει τα πεδία στο αρχείο εισαγωγής είναι ένα TAB, και πληκτρολογήστε το χαρακτήρα στο διπλανό πεδίο.',
    'LBL_DATABASE_FIELD_HELP' => 'Αυτή η στήλη εμφανίζει όλα τα πεδία στην ενότητα. Επιλέξτε ένα πεδίο για να χαρτογραφήσει τα δεδομένα στις σειρές του αρχείου εισαγωγής.',
    'LBL_HEADER_ROW_HELP' => 'Αυτή η στήλη εμφανίζει τις ετικέτες στη σειρά επκεφαλίδας του αρχείου εισαγωγής.',
    'LBL_DEFAULT_VALUE_HELP' => 'Αναφέρατε μια αξία που χρησιμοποιεί για το πεδίο στη δημιουργημένη ή ενημερωμένη εγγραφή, εάν το πεδίο στο αρχείο εισαγωγής δεν περιέχει δεδομένα.',
    'LBL_ROW_HELP' => 'Αυτή η στήλη επιδεικνύει τα δεδομένα στην πρώτη σειρά μη-επικεφαλίδων γραμμών του αρχείου εισαγωγών. Αν οι ετικέτες της γραμμής επικεφαλίδας εμφανίζονται σε αυτήν τη γραμμή, πατήστε Πίσω για να καθορίσετε τη σειρά επικεφαλίδας στις ιδιότητες του αρχείου εισαγωγής.',
    'LBL_SAVE_MAPPING_HELP' => 'Εισάγετε ένα όνομα για να αποθηκεύσετε τις ρυθμίσεις εισαγωγής, συμπεριλαμβανομένων των πεδίων χαρτογραφήσεων και τα ευρετήρια που χρησιμοποιούνται για διπλότυπο έλεγχο. Οι αποθηκευμένες ρυθμίσεις εισαγωγής μπορεί να χρησιμοποιηθούν για μελλοντικές εισαγωγές.',
    'LBL_IMPORT_FILE_SETTINGS_HELP' => 'Κατά τη διάρκεια λήψης του αρχείου εισαγωγών σας, κάποιες ιδιότητες αρχείων έχει ανιχνευθεί αυτόματα. Προβολή και διαχείριση αυτών των ιδιοτήτων, ανάλογα<br> με τις ανάγκες. Σημείωση: Οι παρεχόμενες ρυθμίσεις αναφέρονται εδώ σε αυτήν την εισαγωγή<br> και δεν θα αγνοήσει τις γενικές Ρυθμίσεις Χειριστών σας.',
    'LBL_VERIFY_DUPLCATES_HELP' => 'Βρείτε τις υπάρχουσες εγγραφές στο σύστημα που θα μπορούσαν να θεωρηθούν αντίγραφα των αρχείων που πρόκειται να εισαχθούν από την εκτέλεση ενός διπλότυπου αντιγράφου ελέγχου για αντιστοίχιση δεδομένων. Τα πεδία που σέρνονται στη στήλη «Δεδομένα Ελέγχου» θα χρησιμοποιηθούν για τον διπλότυπο έλεγχο. Οι γραμμές στο αρχείο εισαγωγών σας περιέχουν στοιχεία που ταιριάζουν και θα απαριθμηθούν μέσα στην επόμενη σελίδα, θα είστε σε θέση να επιλέξετε ποιες γραμμές για την εισαγωγή.',
    'LBL_IMPORT_STARTED' => 'Εισαγωγή Ξεκίνησε:',
    'LBL_IMPORT_FILE_SETTINGS' => 'Εισαγωγή Ρυθμίσεων Αρχείου',
    'LBL_RECORD_CANNOT_BE_UPDATED' => 'Η εγγραφή δεν θα μπορούσε να ενημερώνεται λόγω δικαιωμάτων',
    'LBL_DELETE_MAP_CONFIRMATION' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε το αποθηκευμένο σύνολο των ρυθμίσεων εισαγωγής;',
    'LBL_THIRD_PARTY_CSV_SOURCES' => 'Εάν το αρχείο εισαγωγών δεδομένων εξήχθη από οποιεσδήποτε από τις ακόλουθες πηγές, επιλέξτε μία.',
    'LBL_THIRD_PARTY_CSV_SOURCES_HELP' => 'Επιλέξτε την πηγή να εφαρμόσει αυτόματα προσαρμοσμένες χαρτογραφήσεις, προκειμένου να απλοποιηθεί η διαδικασία χαρτογράφησης (επόμενο βήμα).',
    'LBL_EXTERNAL_SOURCE_HELP' => 'Χρησιμοποιήστε αυτήν την επιλογή να εισαχθούν τα δεδομένα άμεσα από μια εξωτερική εφαρμογή ή μια υπηρεσία, όπως Gmail.',
    'LBL_EXAMPLE_FILE' => 'Λήψη Πρότυπου Αρχείου Εισαγωγής',
    'LBL_CONFIRM_IMPORT' => 'Έχετε επιλέξει να ενημερώσετε τις εγγραφές κατά τη διάρκεια της διαδικασίας εισαγωγής. Οι Ανανεώσεις έχουν γίνει στα υπάρχοντα αρχεία δεν μπορούν να αναιρεθούν. Ωστόσο, τα αρχεία που δημιουργούνται κατά τη διαδικασία εισαγωγής μπορούν να αναιρεθούν (διαγραφή), εάν το επιθυμείται. Πατήστε Ακύρωση για να επιλέξει να δημιουργήσει τα νέα αρχεία μόνο, ή πατήστε Εντάξει για να συνεχίσει.',
    'LBL_CONFIRM_MAP_OVERRIDE' => 'Προειδοποίηση: Έχετε επιλέξει ήδη μια προσαρμοσμένη χαρτογράφηση για αυτή την εισαγωγή, θέλετε να συνεχίσετε;',
    'LBL_EXTERNAL_FIELD' => 'Εξωτερικό Πεδίο',
    'LBL_SAMPLE_URL_HELP' => 'Κάντε λήψη ενός αρχείου εισαγωγών δειγμάτων που περιέχει μια σειρά επικεφαλίδων στα πεδία ενοτήτων. Το αρχείο μπορεί να χρησιμοποιηθεί ως πρότυπο για να δημιουργήσει ένα αρχείο εισαγωγών που περιέχει τα δεδομένα που θα επιθυμούσατε να εισαγάγετε.',
    'LBL_AUTO_DETECT_ERROR' => 'Το πεδίο οριοθέτη και χαρακτηριστή, στο αρχείο εισαγωγής δεν μπορούσε να ανιχνευθεί. Παρακαλώ ελέγξτε τις ρυθμίσεις στις ιδιότητες αρχείων εισαγωγών.',
    'LBL_MIME_TYPE_ERROR_1' => 'Το επιλεγμένο αρχείο δεν φαίνεται να περιέχει μια οριοθετημένη λίστα. Παρακαλώ ελέγξτε τον τύπο αρχείου. Συστήνουμε τα κόμμα-οριοθετημένα αρχεία (.csv).',
    'LBL_MIME_TYPE_ERROR_2' => 'Για να συνεχίσετε με την εισαγωγή του επιλεγμένου αρχείου, πατήστε Εντάξει. Για να φορτώσετε ένα νέο αρχείο, πατήστε Δοκιμάστε Ξανά.',
    'LBL_FIELD_DELIMETED_HELP' => 'Το πεδίο οριοθέτης καθορίζει το χαρακτήρα που χρησιμοποιείται για τον διαχωρισμό του πεδίο στηλών.',
    'LBL_FILE_UPLOAD_WIDGET_HELP' => 'Επιλέξτε ένα αρχείο που περιέχει δεδομένα που χωρίζονται από έναν οριοθέτη, όπως ένα οριοθετημένο με κόμμα αρχείο ή ένα οριοθετημένο με tab αρχείο. Τα αρχεία του τύπου .csv συστήνονται.',
    'LBL_EXTERNAL_ERROR_NO_SOURCE' => 'Ανίκανο να ανακτήσει τον προσαρμοστή πηγής, παρακαλώ προσπαθήστε πάλι αργότερα.',
    'LBL_EXTERNAL_ERROR_FEED_CORRUPTED' => 'Δεν είναι δυνατή η ανάκτηση εξωτερικής τροφοδοσίας, παρακαλώ δοκιμάστε ξανά αργότερα.',
    'LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE' => 'Η Εισαγωγή καταλόγου cache δεν είναι εγγράψιμη.',
    'LBL_ADD_FIELD_HELP' => 'Χρησιμοποιήστε αυτή την επιλογή για να προσθέσετε μια αξία σε ένα πεδίο που δημιουργήθηκε σε όλες τις εγγραφές και/ή ενημερώθηκε. Επιλέξτε το πεδίο και στη συνέχεια πληκτρολογήστε ή επιλέξτε μια αξία για αυτό το πεδίο στη στήλη Προεπιλεγμένη Αξία.',
    'LBL_MISSING_HEADER_ROW' => 'Δεν Βρέθηκε Σειρά Επικεφαλίδας',
    'LBL_CANCEL' => 'Ακύρωση',
    'LBL_SELECT_DS_INSTRUCTION' => 'Είστε έτοιμοι να ξεκινήσετε την εισαγωγή; Επιλέξτε την πηγή των δεδομένων που θα θέλατε να εισαγάγετε.',
    'LBL_SELECT_UPLOAD_INSTRUCTION' => 'Επιλέξτε ένα αρχείο στον υπολογιστή σας που περιέχει τα στοιχεία που θα επιθυμούσατε να εισαγάγετε, ή κάντε λήψη του πρότυπου αρχείου για να πάρετε ένα προβάδισμα για τη δημιουργία του αρχείου εισαγωγής.',
    'LBL_SELECT_PROPERTY_INSTRUCTION' => 'Εδώ είναι πώς οι πρώτες διάφορες σειρές του αρχείου εισαγωγών εμφανίζονται με τις ανιχνευμένες ιδιότητες αρχείων. Εάν μια σειρά επικεφαλίδων ανιχνευθεί, επιδεικνύεται στην κορυφαία σειρά του πίνακα. Δείτε τις ιδιότητες αρχείων εισαγωγών για να κάνετε τις αλλαγές στις ανιχνευμένες ιδιότητες και στις καθορισμένες πρόσθετες ιδιότητες. Η ενημέρωση των ρυθμίσεων θα ενημερώσει τα στοιχεία που εμφανίζονται στον πίνακα.',
    'LBL_SELECT_MAPPING_INSTRUCTION' => 'Ο πίνακας περιέχει παρακάτω όλα τα πεδία στην ενότητα που μπορούν να χαρτογραφηθούν στα δεδομένα στο αρχείο εισαγωγών. Αν το αρχείο περιέχει μια σειρά επικεφαλίδας, οι στήλες στο αρχείο έχουν χαρτογραφηθεί σε αντιστοίχιση με τα πεδία. Ελέγξτε τις χαρτογραφήσεις για να βεβαιωθείτε ότι είναι αυτό που περιμένετε, και να κάνετε αλλαγές, ανάλογα με τις ανάγκες. Για να σας βοηθήσει να ελέγξετε τις χαρτογραφήσεις, Γραμμή 1 εμφανίζει τα δεδομένα στο αρχείο. Βεβαιωθείτε να χαρτογραφήσει σε όλα τα υποχρεωτικά πεδία (σημειώνονται με αστερίσκο).',
    'LBL_SELECT_DUPLICATE_INSTRUCTION' => 'Για να αποφύγετε την δημιουργία αντίγραφων εγγραφών, επιλέξετε ποια από τα χαρτογραφημένα πεδία θα θέλατε να χρησιμοποιήσετε για να εκτελέσετε έναν αντίγραφο έλεγχο, καθώς τα δεδομένα εισάγονται. Οι αξίες μέσα στις υφιστάμενες εγγραφές στα επιλεγμένα πεδία θα ελεγχθούν σε σχέση με τα δεδομένα στο αρχείο εισαγωγών. Εάν βρεθούν δεδομένα που ταιριάζουν, οι σειρές στο αρχείο εισαγωγών που περιέχουν τα δεδομένα θα επιδειχθούν μαζί με τα αποτελέσματα εισαγωγών (επόμενη σελίδα). Έπειτα θα είστε σε θέση να επιλέξετε ποια από αυτές τις σειρές θα συνεχίσουν εισαγωγή.',
    'LBL_EXT_SOURCE_SIGN_IN' => 'Είσοδος',
    'LBL_EXT_SOURCE_SIGN_OUT' => 'Αποσύνδεση',
    'LBL_DUP_HELP' => 'Εδώ είναι οι σειρές στο αρχείο εισαγωγής που δεν εισήχθησαν, διότι περιέχουν στοιχεία να ταιριάζουν με τις αξίες στις υπάρχουσες εγγραφές με βάση το αντίγραφο ελέγχου.. Τα δεδομένα που ταιριάζουν είναι υπογραμμισμένα. Για να ξανά-εισαγάγετε αυτές τις σειρές, κατεβάστε την λίστα, κάντε αλλαγές και πατήστε <b>Εισαγωγή Ξανά</b>.',
    'LBL_DESELECT' => 'αποεπιλογή',
    'LBL_SUMMARY' => 'Περίληψη',
    'LBL_OK' => 'Εντάξει',
    'LBL_ERROR_HELP' => 'Εδώ είναι οι σειρές στο αρχείο εισαγωγών που δεν εισήχθησαν λόγω των λαθών. Για να ξανά-εισαγάγετε αυτές τις σειρές, κατεβάστε τον κατάλογο, κάνετε τις αλλαγές και πατήστε<b>Εισαγωγή Ξανά</b>',
    'LBL_EXTERNAL_MAP_HELP' => 'Ο παρακάτω πίνακας περιέχει τα πεδία στην εξωτερική πηγή και τα πεδία ενότητας στους οποίους χαρτογραφούνται. Ελέγξτε τις χαρτογραφήσεις για να βεβαιωθείτε ότι είναι αυτό που περιμένετε, και κάντε τις αλλαγές, ανάλογα με τις ανάγκες. Βεβαιωθείτε να χαρτογραφήσει όλα τα υποχρεωτικά πεδία (σημειώνεται με αστερίσκο).',
    'LBL_EXTERNAL_MAP_NOTE' => 'Θα γίνει προσπάθεια εισαγωγής των επαφών σε όλα τα γκρουπ Επαφών Google.',
    'LBL_EXTERNAL_MAP_NOTE_SUB' => 'Τα Ονόματα των πρόσφατα δημιουργημένων Χειριστών θα είναι εξ ορισμού τα Πλήρη Ονόματα της επαφής Google.',
    'LBL_EXTERNAL_MAP_SUB_HELP' => 'Πατήστε <b>Εισαγωγή Τώρα</b> να ξεκινήσει την εισαγωγή. Οι εγγραφές θα δημιουργηθούν μόνο για τις καταχωρήσεις που περιλαμβάνουν τα τελευταία ονόματα. Οι εγγραφές δεν θα δημιουργηθούν για τα δεδομένα που προσδιορίζονται ως αντίγραφα βασισμένα στα ονόματα και/ή διευθύνσεις email που ταιριάζουν με τις υπαρχουσες εγγραφές.',
    'LBL_EXTERNAL_FIELD_TOOLTIP' => 'Αυτή η στήλη εμφανίζει τα πεδία στην εξωτερική πηγή περιέχοντας δεδομένα που θα χρησιμοποιηθούν για τη δημιουργία νέων εγγραφών.',
    'LBL_EXTERNAL_DEFAULT_TOOPLTIP' => 'Αναφέρατε μια τιμή που θα χρησιμοποιηθεί για το πεδίο στην εγγραφή που δημιουργείται αν το πεδίο στην εξωτερική πηγή δεν περιέχει δεδομένα.',
    'LBL_EXTERNAL_ASSIGNED_TOOLTIP' => 'Για να αναθέσετε τις νέες εγγραφές σε έναν χειριστή εκτός από εσάς, χρησιμοποιήστε την στήλη Αξία Προεπιλογής για να επιλέξετε τις διαφορετικές ομάδες.',
    'LBL_EXTERNAL_TEAM_TOOLTIP' => 'Για να αναθέσετε τις νέες εγγραφές σε ομάδες, εκτός από την ομάδα(ες) προεπιλογής σας, χρησιμοποιήστε την στήλη Αξία Προεπιλογής για να επιλέξετε τις διαφορετικές ομάδες.',
    'LBL_SIGN_IN_HELP' => 'Για να ενεργοποιήσετε αυτή την υπηρεσία, παρακαλείστε να εγγραφείτε στο πλαίσιο των Εξωτερικών Λογαριασμών καρτέλας στις ρυθμίσεις σελίδας του χρήστη σας.',
    'LBL_NO_EMAIL_DEFS_IN_MODULE' => "Προσπαθεί να χειριστεί τις διευθύνσεις email σε Bean που δεν το υποστηρίζει.",
);