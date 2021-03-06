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
$mod_strings = array(
	'DESC_MODULES_INSTALLED'					=> 'Nasledovné moduly boli nainštalované:',
	'DESC_MODULES_QUEUED'						=> 'Nasledovné moduly sú pripravené k inštalácii:',

	'ERR_UW_CANNOT_DETERMINE_GROUP'				=> 'Nemožno určiť Skupinu',
	'ERR_UW_CANNOT_DETERMINE_USER'				=> 'Nemožno určiť Vlastníka',
	'ERR_UW_CONFIG_WRITE'						=> 'Chyba pri aktualizácii súboru config.php, informáciami o novej verzii.',
	'ERR_UW_CONFIG'								=> 'Prosím, umožnite zapisovať do súboru config.php a obnovte, resp. znovu načítajte, túto stránku.',
	'ERR_UW_DIR_NOT_WRITABLE'					=> 'Nemožno zapisovať do Adresára',
	'ERR_UW_FILE_NOT_COPIED'					=> 'Subor nebol skopírovaný',
	'ERR_UW_FILE_NOT_DELETED'					=> 'Problém pri odstraňovaní balíka',
	'ERR_UW_FILE_NOT_READABLE'					=> 'Súbor sa nedá čítať.',
	'ERR_UW_FILE_NOT_WRITABLE'					=> 'Súbor nemožno premiestniť alebo zapísať do',
	'ERR_UW_FLAVOR_2'							=> 'Upgrade Flavor/Dochutenie:',
	'ERR_UW_FLAVOR'								=> 'SugarCRM System Flavor/dochutenie.',
	'ERR_UW_LOG_FILE_UNWRITABLE'				=> 'Súbor ./upgradeWizard.log nebolo možné vytvoriť, ani zapísať doň. Prosím opravte oprávnenie vo Vašom SugarCRM adresári.',
    'ERR_UW_MBSTRING_FUNC_OVERLOAD'				=> 'mbstring.func_overload je nastavené na hodnotu vyššiu než 1. Prosím opravte si to v súbore php.ini a reštartujte webový prehliadač.',
	'ERR_UW_MYSQL_VERSION'						=> 'SugarCRM vyžaduje MySQL verziu 4.1.2 alebo novšiu. Našla sa:',
	'ERR_UW_OCI8_VERSION'				        => 'Vaša verzia Oracle nie je podporovaná Sugar-om. Budete potrebovať nainštalovať verziu, ktorá je kompatibilná s aplikáciou Sugar. Prosím konzultujte maticu kompatibility v Release Notes - poznámkach k vydaniu, pre podporované verzie Oracle. Aktuálna verzia:',
	'ERR_UW_NO_FILE_UPLOADED'					=> 'Určite súbor a skúste to znovu, prosím!',
	'ERR_UW_NO_FILES'							=> 'Došlo ku chybe, neboli nájdené žiadne súbory ku kontrole.',
	'ERR_UW_NO_MANIFEST'						=> 'V .zip súbore chýba manifest.php. Nemožno pokračovať.',
	'ERR_UW_NO_VIEW'							=> 'Bolo špecifikované chybné zobrazenie.',
	'ERR_UW_NO_VIEW2'							=> 'Nedefinované zobrazenie. Choďte do Administrácie k navigácii na túto stránku, prosím.',
	'ERR_UW_NOT_VALID_UPLOAD'					=> 'Neplatný Upload/Nahranie súboru na server',
	'ERR_UW_NO_CREATE_TMP_DIR'					=> 'Nemožno vytvoriť adresár temp. Skontrolujte  povolenie k zápisu.',
	'ERR_UW_ONLY_PATCHES'						=> 'Na tejto stránke možno len náhrávať patches/záplaty.',
    'ERR_UW_PREFLIGHT_ERRORS'					=> 'Behom predletovej kontroly sa vyskytly chyby',
	'ERR_UW_UPLOAD_ERR'							=> 'Došlo k chybe pri nahrávaní súboru, prosím skúste to znova!<br />\n',
	'ERR_UW_VERSION'							=> 'Verzia SugarCRM System:',
    'ERR_UW_WRONG_TYPE'							=> 'Táto stránka nie je určená k prevádzke',
	'ERR_UW_PHP_FILE_ERRORS'					=> array(
													1 => 'Nahraté súbory presiahli direktívu upload_max_filesize v súbore php.ini.',
													2 => 'Nahraté súbory presiahli direktívu MAX_FILE_SIZE tak, že boli určené formulárom HTML.',
													3 => 'Nahrávané súbory boli nahraté len čiastočne.',
													4 => 'Neboli nahraté žiadne súbory.',
													5 => 'Neznáma chyba.',
													6 => 'Chýba dočasná zložka.',
													7 => 'Chyba pri zápise súboru na disk.',
													8 => 'Nahrávanie súboru bolo zastavené pre príponu',
),

    'ERROR_HT_NO_WRITE'                         => 'Nemožno zapisovať do súboru:% s',
    'ERROR_MANIFEST_TYPE'                       => 'Súbor manifestu musí špecifikovať typ balíka.',
    'ERROR_PACKAGE_TYPE'                        => 'Súbor manifestu ukazuje na nespoznaný typ balíka: %s',
    'ERROR_VERSION_INCOMPATIBLE'                => 'Nahratý súbor nie je kompatibilný s touto verziou Sugar-u.',
    'ERROR_FLAVOR_INCOMPATIBLE'                 => 'Súbor k nahratiu nie je kompatibilný s týmto typom (Community Edition, Professional, alebo Enterprise) Sugar-u:',

    'ERROR_UW_CONFIG_DB'                        => 'Error saving %s config var to the db (key %s, value %s).',
    'ERR_NOT_ADMIN'                             => "Unauthorized access to administration.",
    'ERR_NO_VIEW_ACCESS_REASON'                 => 'You do not have permission to access this page.',

    'LBL_BUTTON_BACK'							=> '< Späť',
	'LBL_BUTTON_CANCEL'							=> 'Zrušiť',
	'LBL_BUTTON_DELETE'							=> 'Zmazať balík',
	'LBL_BUTTON_DONE'							=> 'Dokončené',
	'LBL_BUTTON_EXIT'							=> 'Ukončiť',
	'LBL_BUTTON_INSTALL'						=> 'Predletová aktualizácia',
	'LBL_BUTTON_NEXT'							=> 'Ďalší >',
	'LBL_BUTTON_RECHECK'						=> 'Opätovná kontrola',
	'LBL_BUTTON_RESTART'						=> 'Reštart',

	'LBL_UPLOAD_UPGRADE'						=> 'Nahrať Aktualizačný balík',
	'LBL_UPLOAD_FILE_NOT_FOUND'					=> 'Súbor pre Upload sa nenašiel',
	'LBL_UW_BACKUP_FILES_EXIST_TITLE'			=> 'Zálohovanie súborov',
	'LBL_UW_BACKUP_FILES_EXIST'					=> 'Zálohy súborov z tejto modernizácie nájdete na',
	'LBL_UW_BACKUP'								=> 'ZÁLOHOVANIE súborov',
	'LBL_UW_CANCEL_DESC'						=> 'Upgrade - modernizácia bola zrušená. Všetky nakopírované dočasné a nahrané aktualizačné súbory boli odstránené.<br>Stlačte tlačítko " Ďalší " a reštartujte sprievodcu modernizáciou.',
	'LBL_UW_CHARSET_SCHEMA_CHANGE'				=> 'Character Set Schema Changes - Zmeny schém znakovej sady',
	'LBL_UW_CHECK_ALL'							=> 'Skontrolovať všetko',
	'LBL_UW_CHECKLIST'							=> 'Kroky modernizácie',
	'LBL_UW_COMMIT_ADD_TASK_DESC_1'				=> "Zálohy prepísaných súborov sú v nasledovnom adresári:",
	'LBL_UW_COMMIT_ADD_TASK_DESC_2'				=> "Ručné zlúčenie nasledovných súborov:",
	'LBL_UW_COMMIT_ADD_TASK_NAME'				=> 'Proces modernizácie: Ručné zlúčenie súborov',
	'LBL_UW_COMMIT_ADD_TASK_OVERVIEW'			=> 'Prosím, použite niektorú zo svojich porovnávacích -diff metód k zlúčeniu týchto súborov. Pokiaľ to neurobíte, Vaša inštalácia SugarCRM bude nestabilná a modernizácia nekompletná.',
	'LBL_UW_COMPLETE'							=> 'Kompletné',
	'LBL_UW_CONTINUE_CONFIRMATION'              => 'Táto nová verzia Sugar obsahuje nové licenčné dojednania. Chcete pokračovať?',
	'LBL_UW_COMPLIANCE_ALL_OK'					=> 'Všetky systémové požiadavky sú naplnené',
	'LBL_UW_COMPLIANCE_CALLTIME'				=> 'Nastavenie PHP:  [Call Time Pass By Reference]',
	'LBL_UW_COMPLIANCE_CURL'					=> 'cURL modul',
	'LBL_UW_COMPLIANCE_IMAP'					=> 'IMAP modul',
	'LBL_UW_COMPLIANCE_MBSTRING'				=> 'MBStrings modul',
	'LBL_UW_COMPLIANCE_MBSTRING_FUNC_OVERLOAD'	=> 'Parameter MBStrings mbstring.func_overload',
	'LBL_UW_COMPLIANCE_MEMORY'					=> 'Nastavenie PHP: [Memory Limit] nastavenia obmedzenia pamäti',
    'LBL_UW_COMPLIANCE_STREAM'                  => 'Nastavenie PHP: Stream',
	'LBL_UW_COMPLIANCE_MSSQL_MAGIC_QUOTES'		=> 'MS SQL Server & PHP Magic Quotes GPC',
	'LBL_UW_COMPLIANCE_MYSQL'					=> 'Minimálna verzia MySQL',
    'LBL_UW_COMPLIANCE_DB'                      => 'Minimálna Databázová verzia',
	'LBL_UW_COMPLIANCE_PHP_INI'					=> 'Umiestnenie súboru php.ini',
	'LBL_UW_COMPLIANCE_PHP_VERSION'				=> 'Minimálna verzia PHP',
	'LBL_UW_COMPLIANCE_SAFEMODE'				=> 'Nastavenie PHP: [Safe mode] - chránený režim',
	'LBL_UW_COMPLIANCE_TITLE'					=> 'Kontrola nastavení Servera',
	'LBL_UW_COMPLIANCE_TITLE2'					=> 'Detekované nastavenia',
	'LBL_UW_COMPLIANCE_XML'						=> 'XML Parsing - spracovanie XML súborov',
    'LBL_UW_COMPLIANCE_ZIPARCHIVE'				=> 'Podpora Zipu',

	'LBL_UW_COPIED_FILES_TITLE'					=> 'Súbory boli úspešne skopírované',
	'LBL_UW_CUSTOM_TABLE_SCHEMA_CHANGE'			=> 'Zákaznícke zmeny schém tabuliek',

	'LBL_UW_DB_CHOICE1'							=> 'Sprievodca modernizáciou spustil SQL',
	'LBL_UW_DB_CHOICE2'							=> 'Ručné SQL otázky',
	'LBL_UW_DB_INSERT_FAILED'					=> 'Príkaz INSERT - vložiť, zlyhal. Porovnávané súbory sa líšia.',
	'LBL_UW_DB_ISSUES_PERMS'					=> 'Oprávnenia k databáze',
	'LBL_UW_DB_ISSUES'							=> 'Odozvy databázy',
	'LBL_UW_DB_METHOD'							=> 'Metóda aktualizácie databázy',
	'LBL_UW_DB_NO_ADD_COLUMN'					=> 'ALTER TABLE [table] ADD COLUMN [column]',
	'LBL_UW_DB_NO_CHANGE_COLUMN'				=> 'ALTER TABLE [table] CHANGE COLUMN [column]',
	'LBL_UW_DB_NO_CREATE'						=> 'CREATE TABLE [table]',
	'LBL_UW_DB_NO_DELETE'						=> 'DELETE FROM [table]',
	'LBL_UW_DB_NO_DROP_COLUMN'					=> 'ALTER TABLE [table] DROP COLUMN [column]',
	'LBL_UW_DB_NO_DROP_TABLE'					=> 'DROP TABLE [table]',
	'LBL_UW_DB_NO_ERRORS'						=> 'Všetky oprávnenia sú dostupné',
	'LBL_UW_DB_NO_INSERT'						=> 'INSERT INTO [table]',
	'LBL_UW_DB_NO_SELECT'						=> 'SELECT [x] FROM [table]',
	'LBL_UW_DB_NO_UPDATE'						=> 'UPDATE [table]',
	'LBL_UW_DB_PERMS'							=> 'Potrebné oprávnenia',

	'LBL_UW_DESC_MODULES_INSTALLED'				=> 'Nasledovné aktualizačné balíky boli nainštalované:',
	'LBL_UW_END_DESC'							=> 'Systém bol aktualizovaný.',
	'LBL_UW_END_DESC2'							=> 'Ak ste si zvolili ručné spustenie nejakého kroku, ako je zlúčenie súborov alebo SQL dopyty, urobte to teraz, prosím. Váš systém je v nestabilnom stave dokiaľ tento krok nebude dokončený.',
	'LBL_UW_END_LOGOUT_PRE'						=> 'Modernizácia je kompletná.',
	'LBL_UW_END_LOGOUT_PRE2'					=> 'Kliknite na Done/Hotovo k ukončeniu Sprievodcu modernizáciou.',
	'LBL_UW_END_LOGOUT'							=> 'Ak plánujete použiť iný aktualizačný - Upgrade balík, pomocou Aktualizačného sprievodcu, musíte sa pred tým odhlásiť a spätne prihlásiť.',
	'LBL_UW_END_LOGOUT2'						=> 'Odhlásenie',
	'LBL_UW_REPAIR_INDEX'						=> 'Pre zlepšenie výkonnosti databázy, spustite <a href="http://translate.sugarcrm.com/latest/index.php?module=Administration&action=RepairIndex"> Opravu indexov</a>',

	'LBL_UW_FILE_DELETED'						=> "odstránené",
	'LBL_UW_FILE_GROUP'							=> 'Skupina',
	'LBL_UW_FILE_ISSUES_PERMS'					=> 'Oprávnenia k súboru',
	'LBL_UW_FILE_ISSUES'						=> 'Súbor používania',
	'LBL_UW_FILE_NEEDS_DIFF'					=> 'Subor vyžaduje ručné porovnanie',
	'LBL_UW_FILE_NO_ERRORS'						=> 'Všetky súbory sú zapisovateľné',
	'LBL_UW_FILE_OWNER'							=> 'Vlastník',
	'LBL_UW_FILE_PERMS'							=> 'Oprávnenia',
	'LBL_UW_FILE_UPLOADED'						=> 'nahraný',
	'LBL_UW_FILE'								=> 'Názov súboru',
	'LBL_UW_FILES_QUEUED'						=> 'Nasledovné aktualizačné balíky sú pripravené k inštalácii:',
	'LBL_UW_FILES_REMOVED'						=> "Nasledovné súbory  budú odstránené zo systému:",
	'LBL_UW_NEXT_TO_UPLOAD'						=> "Kliknite na tlačítko Next/Ďalej k nahraniu aktualizačných balíkov.",
	'LBL_UW_FROZEN'								=> 'Pred pokračovaním nahrať balík.',
	'LBL_UW_HIDE_DETAILS'						=> 'Skryť detaily',
	'LBL_UW_IN_PROGRESS'						=> 'V činnosti',
	'LBL_UW_INCLUDING'							=> 'Vrátane',
	'LBL_UW_INCOMPLETE'							=> 'Nekompletné',
	'LBL_UW_INSTALL'							=> 'INŠTALÁCIA súboru',
	'LBL_UW_MANUAL_MERGE'						=> 'Zlúčenie súborov',
	'LBL_UW_MODULE_READY_UNINSTALL'				=> "Modul je pripravený k odinštalovaniu. Stlačte tlačítko \"Commit/Schválené\" k pokračovaniu odinštalácie.",
	'LBL_UW_MODULE_READY'						=> "Modul je pripravený k inštalácii. Stlačte tlačítko \"Commit/Schválené\" k pokračovaniu inštalácie.",
	'LBL_UW_NO_INSTALLED_UPGRADES'				=> 'Neboli zistené žiadne uložené modernizácie',
	'LBL_UW_NONE'								=> 'Nič',
	'LBL_UW_NOT_AVAILABLE'						=> 'Nedostupné',
	'LBL_UW_OVERWRITE_DESC'						=> "Všetky zmenené súbory budú prepísané, vrátane zákazníckych kódov a zmien šablón, ktoré ste vykonali. Ste si istý, že chcete pokračovať?",
	'LBL_UW_OVERWRITE_FILES_CHOICE1'			=> 'Prepísať všetky súbory',
	'LBL_UW_OVERWRITE_FILES_CHOICE2'			=> 'Ručne zlúčiť - Všetko zachovať',
	'LBL_UW_OVERWRITE_FILES'					=> 'Spôsob zlučovania',
	'LBL_UW_PATCH_READY'						=> 'Patch/záplata je pripravená pokračovať, Stlačte tlačítko "Commit/Schválenie" dole, k dokončeniu procesu modernizácie.',
	'LBL_UW_PATCH_READY2'						=> '<h2>Upozornenie: Boli nájdené ručne upravené nastavenia</h2><br /><br><br />Nasledujúce súbory majú nové pole alebo upravené nastavenie obrazovky, prostredníctvom Štúdia. Záplata, ktorú sa chystáte nainštalovať, zahŕňa zmeny v týchto súboroch.<br><br /> S<br /><u>každým súborom</u><br />môžete urobiť toto:<br /><br/><br /><ul><br /><li><br />[<br /><b>Default</b><br />] Zachovať Vašu verziu tím, že necháte zaškrtávacie políčko prázdne. Zmeny zo záplaty budou ignorované. </li><br />alebo<br /><li>Přijmite aktualizované soubory tým že zaškrtnete dané políčko. Budete musieť znova aplikovať zmenené nastavenie rozloženia vzhľadu cestou Štúdia.</li><br /></ul>',

	'LBL_UW_PREFLIGHT_ADD_TASK'					=> 'Vytvoriť položku úlohy pre ručné zlúčenie?',
	'LBL_UW_PREFLIGHT_COMPLETE'					=> 'Predletová kontrola',
	'LBL_UW_PREFLIGHT_DIFF'						=> 'Rozdielne',
	'LBL_UW_PREFLIGHT_EMAIL_REMINDER'			=> 'Chcete si poslať email s pripomienkou Ručného zlúčenia?',
	'LBL_UW_PREFLIGHT_FILES_DESC'				=> 'Súbory, vypísané nižšie, boli zmenené. Odstránte zaškrtnutie položiek, ktoré vyžadujú Ručné zlúčenie. <i>Kde boli zistené zmeny rozloženia vzhľadu boli automaticky neoznačené; zaškrtnite tie, ktoré chcete prepísať.</i>',
	'LBL_UW_PREFLIGHT_NO_DIFFS'					=> '<i>Nevyžaduje sa Ručné zlúčenie.</i>',
	'LBL_UW_PREFLIGHT_NOT_NEEDED'				=> '<i>Nie je potrebné.</i>',
	'LBL_UW_PREFLIGHT_PRESERVE_FILES'			=> '<i>Automaticky zachované súbory:</i>',
	'LBL_UW_PREFLIGHT_TESTS_PASSED'				=> '<i>Všetky predletové testy prebehli úspešne. </i>',
	'LBL_UW_PREFLIGHT_TESTS_PASSED2'			=> '<i>Kliknite na "Next/Ďalší", ku skopírovaniu aktualizovaných súborov do systému.</i>',
	'LBL_UW_PREFLIGHT_TESTS_PASSED3'			=> '<i><b>Poznámka:</b><br />Zbytok procesu modernizácie je povinný a je potrebné kliknúť na tlačítko "Ďalší", k jeho ukončeniu Pokiaľ nechcete pokračovať, kliknite na "Zrušiť"</i>',
	'LBL_UW_PREFLIGHT_TOGGLE_ALL'				=> '<i>Zmeniť nastavenie všetkých súborov</i>',

	'LBL_UW_REBUILD_TITLE'						=> '<i>Obnoviť výsledok</i>',
	'LBL_UW_SCHEMA_CHANGE'						=> '<i>Zmeny schémy</i>',

	'LBL_UW_SHOW_COMPLIANCE'					=> '<i>Zobraziť zistené nastavenia</i>',
	'LBL_UW_SHOW_DB_PERMS'						=> '<i>Zobraziť chýbajúce databázové oprávnenia</i>',
	'LBL_UW_SHOW_DETAILS'						=> '<i>Zobraziť detaily</i>',
	'LBL_UW_SHOW_DIFFS'							=> '<i>Zobraziť súbory vyžadujúce Ručné zlúčenie</i>',
	'LBL_UW_SHOW_NW_FILES'						=> '<i>Zobraziť súbory s chybnými oprávneniami</i>',
	'LBL_UW_SHOW_SCHEMA'						=> '<i>Zobraziť zápis zmeny schémy</i>',
	'LBL_UW_SHOW_SQL_ERRORS'					=> '<i>Zobraziť chybné databázové otázky</i>',
	'LBL_UW_SHOW'								=> '<i>Zobraziť</i>',

	'LBL_UW_SKIPPED_FILES_TITLE'				=> '<i>Preskočené súbory</i>',
	'LBL_UW_SKIPPING_FILE_OVERWRITE'			=> '<i>Preskakovanie prepísaných súborov - Vybraté Ručné zlučovanie</i>',
	'LBL_UW_SQL_RUN'							=> '<i>Zaškrtnúť, ak SQL bola spustená ručne</i>',
	'LBL_UW_START_DESC'							=> '<i>Tento sprievodca Vám pomôže pri modernizácii inštancie Sugar</i>',
	'LBL_UW_START_DESC2'						=> '<i><b>Poznámka:</b> Odporúčame Vám zálohovať databázu Sugar a systémové súbory (všetky súbory v zložke SugarCRM), ešte pred modernizáciou Vášho produkčného systému<br><br />Dôrazne odporúčame, najprv vykonať test modernizácie na klonovanej inštancii Vášho produkčného systému.<br /></i>',
	'LBL_UW_START_DESC3'						=> '<i>Kliknite na "Ďalej" k vykonaniu kontroly pripravenosti systému k modernizácii. Kontrola zahŕňa oprávnenia k súborom, databázam a nastavenia servera.</i>',
	'LBL_UW_START_UPGRADED_UW_DESC'				=> '<i>Nový Sprievodca modernizáciou bude teraz pokračovať v procese modernizácie. Pokračujte v modernizácii, prosím.</i>',
	'LBL_UW_START_UPGRADED_UW_TITLE'			=> '<i>Vitajte v novom Sprievodcovi modernizáciou./i>',

	'LBL_UW_SYSTEM_CHECK_CHECKING'				=> '<i>Prebieha kontrola, čakajte prosím. Mohlo by to trvať až 30 sekúnd </i>',
	'LBL_UW_SYSTEM_CHECK_FILE_CHECK_START'		=> '<i>Nájdenie všetkých príslušných súborov, ku kontrole</i>',
	'LBL_UW_SYSTEM_CHECK_FILES'					=> '<i>Súbory</i>',
	'LBL_UW_SYSTEM_CHECK_FOUND'					=> '<i>Nájdené</i>',

	'LBL_UW_TITLE_CANCEL'						=> '<i>Zrušiť</i>',
	'LBL_UW_TITLE_COMMIT'						=> '<i>Schváliť modernizáciu</i>',
	'LBL_UW_TITLE_END'							=> '<i>Prevziať hlásenie</i>',
	'LBL_UW_TITLE_PREFLIGHT'					=> '<i>Predletová kontrola</i>',
	'LBL_UW_TITLE_START'						=> '<i>Vitajte</i>',
	'LBL_UW_TITLE_SYSTEM_CHECK'					=> '<i>Kontrola systému</i>',
	'LBL_UW_TITLE_UPLOAD'						=> '<i>Nahraný balík</i>',
	'LBL_UW_TITLE'								=> '<i>Sprievodca modernizáciou</i>',
	'LBL_UW_UNINSTALL'							=> '<i>Odinštalovať</i>',
	//500 upgrade labels
	'LBL_UW_ACCEPT_THE_LICENSE' 				=> '<i>Prijať Licenciu</i>',
	'LBL_UW_CONVERT_THE_LICENSE' 				=> '<i>Prevod Licencie</i>',
	'LBL_UW_CUSTOMIZED_OR_UPGRADED_MODULES'     => '<i>Aktualizované/Zákaznícke moduly</i>',
	'LBL_UW_FOLLOWING_MODULES_CUSTOMIZED'       => '<i>Nasledovné moduly boli zistené ako zákaznícke a chránené</i>',
	'LBL_UW_FOLLOWING_MODULES_UPGRADED'         => '<i>Nasledovné moduly boli zistené ako zákaznícke, upravené cez Štúdio a boli modernizované</i>',

	'LBL_START_UPGRADE_IN_PROGRESS'             => '<i>Prebieha Štart</i>',
	'LBL_SYSTEM_CHECKS_IN_PROGRESS'             => '<i>Prebieha kontrola systému</i>',
	'LBL_LICENSE_CHECK_IN_PROGRESS'             => '<i>Prebieha licenčná kontrola</i>',
	'LBL_PREFLIGHT_CHECK_IN_PROGRESS'           => '<i>Prebieha predletová kontrola</i>',
    'LBL_PREFLIGHT_FILE_COPYING_PROGRESS'       => '<i>Prebieha kopírovanie súborov</i>',
	'LBL_COMMIT_UPGRADE_IN_PROGRESS'            => '<i>Prebieha schválenie a spustenie modernizácie</i>',
    'LBL_UW_COMMIT_DESC'						=> '<i>Kliknite na "Ďalší" k spusteniu ďalších modernizačných skriptov</i>',
	'LBL_UPGRADE_SCRIPTS_IN_PROGRESS'			=> '<i>Prebiehajú modernizačné skripty</i>',
	'LBL_UPGRADE_SUMMARY_IN_PROGRESS'			=> '<i>Prebieha zhrnutie modernizácie</i>',
	'LBL_UPGRADE_IN_PROGRESS'                   => '<i>Prebieha</i>',
	'LBL_UPGRADE_TIME_ELAPSED'                  => '<i>Uplynutý čas</i>',
	'LBL_UPGRADE_CANCEL_IN_PROGRESS'			=> '<i>Prebieha zrušenie modernizácie a čistenie</i>',
    'LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE'      => '<i>Modernizácia môže nejaký čas trvať</i>',
    'LBL_UPLOADE_UPGRADE_IN_PROGRESS'           => '<i>Prebieha kontrola Upload/nahrania</i>',
	'LBL_UPLOADING_UPGRADE_PACKAGE'      		=> '<i>Prebieha Upload/nahrávanie modernizácie</i>',
    'LBL_UW_DORP_THE_OLD_SCHMEA' 				=> '<i>Chcete aby Sugar zachoval starú schému 451 ?</i>',
	'LBL_UW_DROP_SCHEMA_UPGRADE_WIZARD'			=> '<i>Sprievodca modernizáciou zachováva starú schému 451 </i>',
	'LBL_UW_DROP_SCHEMA_MANUAL'					=> 'Nastavenie manuálneho výberu modernizácie poštovej schémy',
	'LBL_UW_DROP_SCHEMA_METHOD'					=> 'Nastavenie starého vkladania schém.',
	'LBL_UW_SHOW_OLD_SCHEMA_TO_DROP'			=> 'Ukáž starú schému, ktorá má byť vložená',
	'LBL_UW_SKIPPED_QUERIES_ALREADY_EXIST'      => 'Preskočené otázky',
	'LBL_INCOMPATIBLE_PHP_VERSION'              => 'Je požadovaná Verzia PHP 5 alebo vyššia.',
	'ERR_CHECKSYS_PHP_INVALID_VER'      => 'Vaša verzia PHP nepodporuje Sugar. Budete potrebovať nainštalovať verziu, kompatibilnú s aplikáciou Sugar. Postupujte podľa matice kompatibility a vzťahujúcich sa poznámok pre podporovanú verziu PHP. Vaša verzia je',
	'LBL_BACKWARD_COMPATIBILITY_ON' 			=> 'PHP Backward Compatibility - kompatibilita na nižšie verzie PHP - je zapnutá. Nastavte zend.ze1_compatibility_mode na OFF, pre pokračovanie ďalej',
	//including some strings from moduleinstall that are used in Upgrade
	'LBL_ML_ACTION' => 'Akcia',
    'LBL_ML_CANCEL'             => 'Zrušiť',
    'LBL_ML_COMMIT'=>'Schváliť',
    'LBL_ML_DESCRIPTION' => 'Popis',
    'LBL_ML_INSTALLED' => 'Dátum inštalácie',
    'LBL_ML_NAME' => 'Meno',
    'LBL_ML_PUBLISHED' => 'Dátum zverejnenia',
    'LBL_ML_TYPE' => 'Typ',
    'LBL_ML_UNINSTALLABLE' => 'Neinštalovateľné',
    'LBL_ML_VERSION' => 'Verzia',
	'LBL_ML_INSTALL'=>'Inštalovať',
	//adding the string used in tracker. copying from homepage
	'LBL_HOME_PAGE_4_NAME' => 'Stopár',
	'LBL_CURRENT_PHP_VERSION' => '(Vaša aktuálna verzia PHP je',
	'LBL_RECOMMENDED_PHP_VERSION' => '. Odporúčaná verzia PHP je 5.2.1 alebo vyššia',
	'LBL_MODULE_NAME' => 'Sprievodca modernizáciou',
	'LBL_MODULE_NAME_SINGULAR' => 'Sprievodca modernizáciou',
	'LBL_UPLOAD_SUCCESS' => 'Modernizačný balík bol úspešne nahratý. Kliknite na "Ďalší" k vykonaniu záverečnej kontroly.',
	'LBL_UW_TITLE_LAYOUTS' => 'Potvrdenie rozloženia',
	'LBL_LAYOUT_MODULE_TITLE' => 'Rozloženie',
	'LBL_LAYOUT_MERGE_DESC' => 'Tu sú k dispozícii nové polia, ktoré boli pridané ako časť tejto modernizácie a môžu byť automaticky pripojené do rozloženia existujúceho modulu. Ak sa chcete dozvedieť viac o nových poliach, prosím prejdite k Release Notes - Poznámky k vydaniu, pre verziu ktorú modernizujete.<br><br><br />Ak si neželáte pripojiť nové polia, prosím, odznačte modul a Vaše zákaznícke rozloženie zostane nezmenené. Polia budú dostupné v Štúdiu po modernizácii.',
	'LBL_LAYOUT_MERGE_TITLE' => 'Kliknite na "Ďalej" k potvrdeniu zmien a ukončeniu modernizácie.',
	'LBL_LAYOUT_MERGE_TITLE2' => 'Kliknite na "Ďalej" k dokončeniu modernizácie.',
	'LBL_UW_CONFIRM_LAYOUTS' => 'Potvrdiť rozloženie',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS' => 'Potvrdiť rozloženie výsledkov',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS_DESC' => 'Nasledovné rozloženia boli úspešne zlúčené:',
	'LBL_SELECT_FILE' => 'Výber súboru:',
	'LBL_LANGPACKS' => 'Jazykové balíky' /*for 508 compliance fix*/,
	'LBL_MODULELOADER' => 'Načítanie modulov' /*for 508 compliance fix*/,
	'LBL_PATCHUPGRADES' => 'Patch Upgrades' /*for 508 compliance fix*/,
	'LBL_THEMES' => 'Témy' /*for 508 compliance fix*/,
	'LBL_WORKFLOW' => 'Workflow' /*for 508 compliance fix*/,
	'LBL_UPGRADE' => 'Upgrade' /*for 508 compliance fix*/,
	'LBL_PROCESSING' => 'Processing' /*for 508 compliance fix*/,
    'LBL_GLOBAL_TEAM_DESC'                      => 'Viditeľný globálne',
);
