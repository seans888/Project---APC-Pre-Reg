<?php
if($go_create == "make it so")
{
    $db = new SQLite3('metadata' . DIRECTORY_SEPARATOR . 'cobalt.db');

    //*******************************
    //CREATE TABLES

    //database_connection
    $db->exec('CREATE TABLE database_connection(DB_Connection_ID TEXT PRIMARY KEY,
                                                Project_ID TEXT,
                                                DB_Connection_Name TEXT,
                                                Hostname TEXT,
                                                Username TEXT,
                                                Password TEXT,
                                                "Database" TEXT)');
    //page
    $db->exec('CREATE TABLE page(Page_ID TEXT PRIMARY KEY,
                                 Page_Name TEXT,
                                 Generator TEXT,
                                 Description TEXT)');
    //project
    $db->exec('CREATE TABLE project(Project_ID TEXT PRIMARY KEY,
                                    Project_Name TEXT,
                                    Client_Name TEXT,
                                    Project_Description TEXT,
                                    Base_Directory TEXT,
                                    Database_Connection_ID TEXT)');
    //table
    $db->exec('CREATE TABLE "table"(Table_ID TEXT PRIMARY KEY,
                                  Project_ID TEXT,
                                  DB_Connection_ID TEXT,
                                  Table_Name TEXT,
                                  Remarks TEXT)');
    //table_fields
    $db->exec('CREATE TABLE table_fields(Field_ID TEXT PRIMARY KEY,
                                         Table_ID TEXT,
                                         Field_Name TEXT,
                                         Data_Type TEXT,
                                         Nullable TEXT,
                                         Length TEXT,
                                         Attribute TEXT,
                                         Auto_Increment TEXT,
                                         Control_Type TEXT,
                                         Label TEXT,
                                         In_Listview TEXT,
                                         Default_Value TEXT,
                                         Required TEXT,
                                         Size TEXT,
                                         Upload_Path TEXT,
                                         Extra TEXT,
                                         Companion TEXT,
                                         Char_Set_Method TEXT,
                                         Char_Set_Allow_Space TEXT,
                                         Extra_Chars_Allowed TEXT,
                                         Allow_HTML_Tags TEXT,
                                         Trim_Value TEXT,
                                         Valid_Set TEXT,
                                         Date_Default TEXT,
                                         Drop_Down_Has_Blank TEXT,
                                         RPT_In_Report TEXT,
                                         RPT_Column_Format TEXT,
                                         RPT_Column_Alignment TEXT,
                                         RPT_Show_Sum TEXT
                                         )');
    //table_fields_list
    $db->exec('CREATE TABLE table_fields_list(Field_ID TEXT,
                                              List_ID TEXT)');

    //table_fields_list_source_select
    $db->exec('CREATE TABLE table_fields_list_source_select(Field_ID TEXT,
                                                            Auto_ID INTEGER,
                                                            Select_Field_ID TEXT,
                                                            Display TEXT)');
    //table_fields_list_source_where
    $db->exec('CREATE TABLE table_fields_list_source_where(Field_ID TEXT,
                                                           Where_Field_ID TEXT,
                                                           Where_Field_Operand TEXT,
                                                           Where_Field_Value TEXT,
                                                           Where_Field_Connector TEXT)');
    //table_fields_predefined_list
    $db->exec('CREATE TABLE table_fields_predefined_list(List_ID TEXT PRIMARY KEY,
                                                         Project_ID TEXT,
                                                         List_Name TEXT,
                                                         Remarks TEXT)');
    //table_fields_predefined_list_items
    $db->exec('CREATE TABLE table_fields_predefined_list_items(List_ID TEXT,
                                                               "Number" TEXT,
                                                               List_Item TEXT)');
    //table_pages
    $db->exec('CREATE TABLE table_pages(Table_ID TEXT,
                                        Page_ID TEXT,
                                        Path_Filename TEXT)');

    //table_relations
    $db->exec('CREATE TABLE table_relations(Relation_ID TEXT PRIMARY KEY,
                                            Project_ID TEXT,
                                            Relation TEXT,
                                            Parent_Field_ID TEXT,
                                            Child_Field_ID TEXT,
                                            Label TEXT,
                                            Child_Field_Subtext TEXT)');

    // END of CREATE TABLES
    //********************************************


    //********************************************
    //INSERT DEFAULT CONTENTS
    $stmt = $db->prepare('INSERT INTO page(Page_ID, Page_Name, Generator, Description) VALUES (:p_id, :p_name, :gen, :description)');
    $stmt->bindValue(':p_id', "+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "Add1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "Add1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Standard input form", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "Edit1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "Edit1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Standard edit form", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "DetailView1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "DetailView1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Detail View of a record", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "ListView", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "ListView1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "List View of a table", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "Delete1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "Delete1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Standard record deletion page", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "CSVExport1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "CSVExport1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Standard export data to CSV module", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "ReporterInterface1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "ReporterInterface1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Default custom reporting tool interface", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "ReporterResult1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "ReporterResult1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Default custom reporting tool result page", SQLITE3_TEXT);
    $stmt->execute();
    $stmt->bindValue(':p_id', "EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=", SQLITE3_TEXT);
    $stmt->bindValue(':p_name', "ReporterResultPDF1", SQLITE3_TEXT);
    $stmt->bindValue(':gen', "ReporterResultPDF1.php", SQLITE3_TEXT);
    $stmt->bindValue(':description', "Default custom reporting tool PDF result", SQLITE3_TEXT);
    $stmt->execute();
    //********************************************

    //Create marker that indicates database creation was successful
    $f = fopen("metadata/status","wb");
    fwrite($f, "Complete");
    fclose($f);
}
else
{
    die();
}
