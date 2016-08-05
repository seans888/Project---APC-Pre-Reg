OPTIMIZE TABLE `project`, `database_connection`, `table`, `table_fields`, `table_fields_list`, `table_fields_list_source_select`, `table_fields_list_source_where`, `table_pages`, `table_relations`,`table_fields_predefined_list`, `table_fields_predefined_list_items`;


INSERT INTO `project`(Project_ID, Project_Name, Client_Name, Project_Description, Base_Directory, Database_Connection_ID) VALUES('Z2rn1sK6D0ThX84753iK/A', 'Test', 'test', 'test', 'test', 'JzY7bzyEhQhOMHNwpVNSmg');


INSERT INTO `database_connection`(DB_Connection_ID, Project_ID, DB_Connection_Name, Hostname, Username, Password, `Database`) VALUES('JzY7bzyEhQhOMHNwpVNSmg', 'Z2rn1sK6D0ThX84753iK/A', 'con1', 'localhost', 'root', '','test');


INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'award', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'department', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'employee', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'employee_awards', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'employee_hobbies', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('TKjASFh6YJVul25af1oVgA', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'experiments', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'office_docs', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'positions', '');
INSERT INTO `table`(Table_ID, Project_ID, DB_Connection_ID, Table_Name, Remarks) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'Z2rn1sK6D0ThX84753iK/A', 'JzY7bzyEhQhOMHNwpVNSmg', 'salary_grade', '');


INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('XCrEydeVHpbr8i/Nu9Zaog', '+PZdSvv9VIY1csmHmDqx7Q', 'award_id', 'integer', 'NO', '11', 'primary key', 'none', 'Award ID', 'no', 'Y');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('3Vzb2cb4Y+aTIx7EsczNNw', '+PZdSvv9VIY1csmHmDqx7Q', 'title', 'varchar', 'NO', '255', '', 'textbox', 'Title', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('NSTfoJmgk48h6wgtEg2FJQ', '+PZdSvv9VIY1csmHmDqx7Q', 'description', 'text', 'NO', '0', '', 'textarea', 'Description', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('Vw3c5jDs/dvzxZ5tkRLpSw', 'GpfmZALgsqCJ8ftNn6bCKw', 'dept_id', 'integer', 'NO', '11', 'primary key', 'none', 'Dept ID', 'no', 'Y');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('nSETbUkLg0KkXWGGWzx8OA', 'GpfmZALgsqCJ8ftNn6bCKw', 'dept_short_name', 'varchar', 'NO', '255', '', 'textbox', 'Dept Short Name', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('As0q5T+2CODWodM92JPASQ', 'GpfmZALgsqCJ8ftNn6bCKw', 'dept_official_name', 'varchar', 'NO', '255', '', 'textbox', 'Dept Official Name', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('VMTaSHAYhNZ0virFsshuOQ', 'GpfmZALgsqCJ8ftNn6bCKw', 'dept_head', 'varchar', 'NO', '255', 'foreign key', 'drop-down list', 'Dept Head', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('zB4sEuLniGAtdcqdsTCnaw', 'Zg+By6nvuEEyAjQZ4PD3nw', 'emp_id', 'varchar', 'NO', '255', 'primary key', 'textbox', 'Emp ID', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('fyAcGFgDtwxf08dDTAf+uQ', 'Zg+By6nvuEEyAjQZ4PD3nw', 'first_name', 'varchar', 'NO', '255', '', 'textbox', 'First Name', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('mtI2uNmtcHXeGK5M5CwWZA', 'Zg+By6nvuEEyAjQZ4PD3nw', 'middle_name', 'varchar', 'NO', '255', '', 'textbox', 'Middle Name', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('6i949zMcLJptBU+CHhCRkA', 'Zg+By6nvuEEyAjQZ4PD3nw', 'last_name', 'varchar', 'NO', '255', '', 'textbox', 'Last Name', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('5LIMyrEX85yuY47ZYXzOwA', 'Zg+By6nvuEEyAjQZ4PD3nw', 'gender', 'varchar', 'NO', '255', 'none', 'radio buttons', 'Gender', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('w9Y6+EBXyzKFnT8ClZV08w', 'Zg+By6nvuEEyAjQZ4PD3nw', 'civil_status', 'varchar', 'NO', '255', 'none', 'drop-down list', 'Civil Status', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('fLbWURvz4PaN9aJegoN8nw', 'Zg+By6nvuEEyAjQZ4PD3nw', 'birthday', 'date', 'NO', '0', '', 'date controls', 'Birthday', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('JXKx8dGWF/HWWhpxmltDKA', 'Zg+By6nvuEEyAjQZ4PD3nw', 'hiring_date', 'date', 'NO', '0', '', 'date controls', 'Hiring Date', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('BW9qIoHHCEFug7RTOG5GFw', 'Zg+By6nvuEEyAjQZ4PD3nw', 'dept_id', 'integer', 'NO', '11', 'foreign key', 'drop-down list', 'Dept', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('MdAeM2dK9zeDFcL869IATg', 'Zg+By6nvuEEyAjQZ4PD3nw', 'position_id', 'integer', 'NO', '11', 'foreign key', 'drop-down list', 'Position', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('mXbCy9gmzf0bDBriDk3JGg', 'Zg+By6nvuEEyAjQZ4PD3nw', 'salary_grade_id', 'integer', 'NO', '11', 'foreign key', 'drop-down list', 'Salary Grade', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('pNRKObmX00Nc6qBBfhJjMQ', 'yAkgJ6CPUIiS/osXGlabpw', 'emp_id', 'varchar', 'NO', '255', 'primary&foreign key', 'drop-down list', 'Emp', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('ofRwKpjv38k86zrbXxEkeA', 'yAkgJ6CPUIiS/osXGlabpw', 'auto_id', 'integer', 'NO', '11', 'primary key', 'none', 'Auto ID', 'no', 'Y');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('Gj38GKEUcDQjTRZmIjDh0A', 'yAkgJ6CPUIiS/osXGlabpw', 'award_id', 'integer', 'NO', '11', 'foreign key', 'drop-down list', 'Award', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('wQUyO45+xqXh3jYmC0RQ5A', 'yAkgJ6CPUIiS/osXGlabpw', 'date_received', 'date', 'NO', '0', '', 'date controls', 'Date Received', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('wEnGaEOnlqjve4OEXrIWFQ', 'LW0Xg6sAL3W5YmwWJEJUhg', 'emp_id', 'varchar', 'NO', '255', 'primary&foreign key', 'drop-down list', 'Emp', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('OTjrK7yFMVLGZVahjJhJAg', 'LW0Xg6sAL3W5YmwWJEJUhg', 'auto_id', 'integer', 'NO', '11', 'primary key', 'none', 'Auto ID', 'no', 'Y');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('CoDfSpLeFy2i4TCy4yAu9Q', 'LW0Xg6sAL3W5YmwWJEJUhg', 'hobby', 'varchar', 'NO', '255', '', 'textbox', 'Hobby', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('lX4AtbmaAF0o/3rSnP4THg', 'TKjASFh6YJVul25af1oVgA', 'experiment_id', 'integer', 'NO', '11', 'primary key', 'none', 'Experiment ID', 'no', 'Y');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('Gf08bg/qAKOrN09t+DvnBQ', 'TKjASFh6YJVul25af1oVgA', 'date', 'date', 'NO', '0', '', 'date controls', 'Date', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('a6+v6t1MKyqpl2ymPzL/vw', 'TKjASFh6YJVul25af1oVgA', 'title', 'varchar', 'NO', '255', '', 'textbox', 'Title', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('IMEV2WGVDjTHNNdhTI6pLg', 'TKjASFh6YJVul25af1oVgA', 'description', 'varchar', 'NO', '255', '', 'textarea', 'Description', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('ebDn20SLTgVv7Ye+4PnxwQ', 'TKjASFh6YJVul25af1oVgA', 'preliminary_result', 'varchar', 'NO', '255', 'none', 'upload', 'Preliminary Result', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('EvZ+yxa0CROzAYf50bSI3g', 'TKjASFh6YJVul25af1oVgA', 'intermediate_result', 'varchar', 'NO', '255', 'none', 'upload', 'Intermediate Result', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('fa1r5eUDL5QDkeYicEz+nQ', 'TKjASFh6YJVul25af1oVgA', 'final_result', 'varchar', 'NO', '255', 'none', 'upload', 'Final Result', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('LLpYZA3KBa9yK2ZbpRoJcA', 'L6iTc1pUeHfu+AEyht1xiA', 'code_1', 'varchar', 'NO', '4', 'primary key', 'textbox', 'Code 1', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('3ADZodVnqFOJ/yRXO3vbig', 'L6iTc1pUeHfu+AEyht1xiA', 'code_2', 'varchar', 'NO', '2', 'primary key', 'textbox', 'Code 2', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('6/ZC0cip7s+QwzmlbxTcIg', 'L6iTc1pUeHfu+AEyht1xiA', 'code_3', 'varchar', 'NO', '5', 'primary key', 'textbox', 'Code 3', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('wuDa6KnMH68FKnMqJohqLA', 'L6iTc1pUeHfu+AEyht1xiA', 'title', 'varchar', 'NO', '255', '', 'textbox', 'Title', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('FO5C/kXaHgPufthQTgAA9Q', 'L6iTc1pUeHfu+AEyht1xiA', 'description', 'varchar', 'NO', '255', '', 'textarea', 'Description', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('uV9S62Vf2gWy3/6G0xFPtQ', 'L6iTc1pUeHfu+AEyht1xiA', 'file_upload', 'varchar', 'NO', '255', 'none', 'upload', 'File Upload', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('gdL6hLCo2D9xQJEfnKh4gQ', 'fXADEBw5/Q7WPzUk9X5BnQ', 'position_id', 'integer', 'NO', '11', 'primary key', 'none', 'Position ID', 'no', 'Y');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('Jz584+J8BS4UJoU5c3bQkg', 'fXADEBw5/Q7WPzUk9X5BnQ', 'title', 'varchar', 'NO', '255', '', 'textbox', 'Title', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('u9VrthWVoMWJOBvUMXybtQ', 'fXADEBw5/Q7WPzUk9X5BnQ', 'description', 'text', 'NO', '0', '', 'textarea', 'Description', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('fwVP55RIhZJzfDTyJXF6+Q', 'cs8eIVfQSdsnEA5LeoUytg', 'salary_grade_id', 'integer', 'NO', '11', 'primary key', 'none', 'Salary Grade ID', 'no', 'Y');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('AhGY6Gu7H82v5OXl8NPiJw', 'cs8eIVfQSdsnEA5LeoUytg', 'title', 'varchar', 'NO', '255', '', 'textbox', 'Title', 'yes', 'N');
INSERT INTO `table_fields`(Field_ID, Table_ID, Field_Name, Data_Type, Nullable, Length, Attribute, Control_Type, Label, In_Listview, Auto_Increment) VALUES('iJj9rHMz0XTIAyJoDBCS8Q', 'cs8eIVfQSdsnEA5LeoUytg', 'description', 'text', 'NO', '0', '', 'textarea', 'Description', 'yes', 'N');


INSERT INTO `table_fields_list`(Field_ID, List_ID) VALUES('5LIMyrEX85yuY47ZYXzOwA', 'GX0IJdt9NViXE2AosyE4nw');
INSERT INTO `table_fields_list`(Field_ID, List_ID) VALUES('w9Y6+EBXyzKFnT8ClZV08w', 'c024fpSriZe2Q8CqbnIupw');


INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('MdAeM2dK9zeDFcL869IATg', '1', 'gdL6hLCo2D9xQJEfnKh4gQ', 'No');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('MdAeM2dK9zeDFcL869IATg', '2', 'Jz584+J8BS4UJoU5c3bQkg', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('mXbCy9gmzf0bDBriDk3JGg', '1', 'fwVP55RIhZJzfDTyJXF6+Q', 'No');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('mXbCy9gmzf0bDBriDk3JGg', '2', 'AhGY6Gu7H82v5OXl8NPiJw', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('VMTaSHAYhNZ0virFsshuOQ', '1', 'zB4sEuLniGAtdcqdsTCnaw', 'No');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('VMTaSHAYhNZ0virFsshuOQ', '2', '6i949zMcLJptBU+CHhCRkA', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('VMTaSHAYhNZ0virFsshuOQ', '3', 'fyAcGFgDtwxf08dDTAf+uQ', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('VMTaSHAYhNZ0virFsshuOQ', '4', 'mtI2uNmtcHXeGK5M5CwWZA', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('BW9qIoHHCEFug7RTOG5GFw', '1', 'Vw3c5jDs/dvzxZ5tkRLpSw', 'No');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('BW9qIoHHCEFug7RTOG5GFw', '2', 'nSETbUkLg0KkXWGGWzx8OA', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('Gj38GKEUcDQjTRZmIjDh0A', '1', 'XCrEydeVHpbr8i/Nu9Zaog', 'No');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('Gj38GKEUcDQjTRZmIjDh0A', '2', '3Vzb2cb4Y+aTIx7EsczNNw', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('pNRKObmX00Nc6qBBfhJjMQ', '1', 'zB4sEuLniGAtdcqdsTCnaw', 'No');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('pNRKObmX00Nc6qBBfhJjMQ', '2', '6i949zMcLJptBU+CHhCRkA', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('pNRKObmX00Nc6qBBfhJjMQ', '3', 'fyAcGFgDtwxf08dDTAf+uQ', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('pNRKObmX00Nc6qBBfhJjMQ', '4', 'mtI2uNmtcHXeGK5M5CwWZA', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('wEnGaEOnlqjve4OEXrIWFQ', '1', 'zB4sEuLniGAtdcqdsTCnaw', 'No');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('wEnGaEOnlqjve4OEXrIWFQ', '2', '6i949zMcLJptBU+CHhCRkA', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('wEnGaEOnlqjve4OEXrIWFQ', '3', 'fyAcGFgDtwxf08dDTAf+uQ', 'Yes');
INSERT INTO `table_fields_list_source_select`(Field_ID, Auto_ID, Select_Field_ID, Display) VALUES('wEnGaEOnlqjve4OEXrIWFQ', '4', 'mtI2uNmtcHXeGK5M5CwWZA', 'Yes');


INSERT INTO `table_fields_list_source_where`(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES('MdAeM2dK9zeDFcL869IATg', '0', '', '', '');
INSERT INTO `table_fields_list_source_where`(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES('mXbCy9gmzf0bDBriDk3JGg', '0', '', '', '');
INSERT INTO `table_fields_list_source_where`(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES('VMTaSHAYhNZ0virFsshuOQ', '0', '', '', '');
INSERT INTO `table_fields_list_source_where`(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES('BW9qIoHHCEFug7RTOG5GFw', '0', '', '', '');
INSERT INTO `table_fields_list_source_where`(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES('Gj38GKEUcDQjTRZmIjDh0A', '0', '', '', '');
INSERT INTO `table_fields_list_source_where`(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES('pNRKObmX00Nc6qBBfhJjMQ', '0', '', '', '');
INSERT INTO `table_fields_list_source_where`(Field_ID, Where_Field_ID, Where_Field_Operand, Where_Field_Value, Where_Field_Connector) VALUES('wEnGaEOnlqjve4OEXrIWFQ', '0', '', '', '');


INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('+PZdSvv9VIY1csmHmDqx7Q', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_award.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('GpfmZALgsqCJ8ftNn6bCKw', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_department.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('Zg+By6nvuEEyAjQZ4PD3nw', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_employee.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('yAkgJ6CPUIiS/osXGlabpw', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_employee_awards.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('LW0Xg6sAL3W5YmwWJEJUhg', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_employee_hobbies.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('TKjASFh6YJVul25af1oVgA', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_experiments.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('L6iTc1pUeHfu+AEyht1xiA', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_office_docs.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('fXADEBw5/Q7WPzUk9X5BnQ', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_positions.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', '+nSXSR+3BnhhMmaBfNYLbZW1Klls8lauC+9jhXjFZPg=', 'add_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', '/0CxWVJHlM+Z9jATzhv6vAHQnuZZWS4URCnxcUxceXc=', 'reporter_result_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'alOVwAQ+rL1qGsKXzH3ntUOTsz3+58x/CjrGwNCoLZU=', 'edit_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'AoJ17xCURhNmjVr+1xWj5Ipr8Jqf461C5RKOc6oCY5s=', 'detailview_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'DMOnHB6R/wc6cXt89xU9OUTRxKMYr7mnlvpUZidmV7g=', 'csv_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'EAOGEEl9nxgSOWL/Rb5QoOYKSwEPz/eM8wakTQEEk3o=', 'reporter_pdfresult_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'Mv+1k7TH5VAPb74N+qvQCfXbqWhlyILNtEvdMQHKIxA=', 'listview_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'qWMTJddAsNYOu7YBrSc/AV79roA/630phvlC4N6Z7KI=', 'delete_salary_grade.php');
INSERT INTO `table_pages`(Table_ID, Page_ID, Path_Filename) VALUES('cs8eIVfQSdsnEA5LeoUytg', 'X0JsxS82n8sIFiKwpQCR9c99doOFEsHIxs4pDGZxg+8=', 'reporter_salary_grade.php');


INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('Adp9EJcodleZ8LbAIffHPQ', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-ONE', 'gdL6hLCo2D9xQJEfnKh4gQ', 'MdAeM2dK9zeDFcL869IATg', 'positions=>employee', 'title');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('znIxL+eo6Z5cVEGXt4eGHw', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-ONE', 'fwVP55RIhZJzfDTyJXF6+Q', 'mXbCy9gmzf0bDBriDk3JGg', 'salary_grade=>employee', 'title');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('Pv1rZFZQRBxVm8n7ANQz1g', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-ONE', 'zB4sEuLniGAtdcqdsTCnaw', 'VMTaSHAYhNZ0virFsshuOQ', 'employee=>department', 'last_name, first_name, middle_name');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('t3mqrf4V2CuDN0GLGGOQwQ', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-ONE', 'Vw3c5jDs/dvzxZ5tkRLpSw', 'BW9qIoHHCEFug7RTOG5GFw', 'department=>employee', 'dept_short_name');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('mmxnK52BTxF7AJ3flBK9KQ', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-ONE', 'XCrEydeVHpbr8i/Nu9Zaog', 'Gj38GKEUcDQjTRZmIjDh0A', 'award=>employee_awards', 'title');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('pAB1kc42PHAUc4chUWrySg', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-MANY', 'zB4sEuLniGAtdcqdsTCnaw', 'pNRKObmX00Nc6qBBfhJjMQ', 'employee=>employee_awards', '');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('nmkw4QuxAlVduAM5NKdkCg', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-MANY', 'zB4sEuLniGAtdcqdsTCnaw', 'wEnGaEOnlqjve4OEXrIWFQ', 'employee=>employee_hobbies', '');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('R086f5KYwBJAHYNtVWQA2A', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-ONE', 'zB4sEuLniGAtdcqdsTCnaw', 'pNRKObmX00Nc6qBBfhJjMQ', 'employee=>employee_awards', 'last_name, first_name, middle_name');
INSERT INTO `table_relations`(Relation_ID, Project_ID, Relation, Parent_Field_ID, Child_Field_ID, Label, Child_Field_Subtext) VALUES('YBpph6xxBmfNQTxcUN2TdQ', 'Z2rn1sK6D0ThX84753iK/A', 'ONE-to-ONE', 'zB4sEuLniGAtdcqdsTCnaw', 'wEnGaEOnlqjve4OEXrIWFQ', 'employee=>employee_hobbies', 'last_name, first_name, middle_name');


INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES('GX0IJdt9NViXE2AosyE4nw', 'Z2rn1sK6D0ThX84753iK/A', 'Male/Female', 'Male/Female gender list');
INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES('Or8o41m1xyq/AC5M7G3alg', 'Z2rn1sK6D0ThX84753iK/A', 'On/Off', 'On/Off status list');
INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES('VNXzTfBiIzfarqMVf0pIhw', 'Z2rn1sK6D0ThX84753iK/A', 'TRUE/FALSE', 'TRUE/FALSE list');
INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES('SFmH6x5A+dfVScLkUI/eLg', 'Z2rn1sK6D0ThX84753iK/A', 'M/F', 'Single character male/female gender list');
INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES('PgnxgHCec02WldxcjlKgnw', 'Z2rn1sK6D0ThX84753iK/A', 'Yes/No', 'Yes/No list');
INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES('MYxwtlj0ofxGOZjtemv7tQ', 'Z2rn1sK6D0ThX84753iK/A', 'Y/N', 'Single character yes/no list');
INSERT INTO `table_fields_predefined_list`(List_ID, Project_ID, List_Name, Remarks) VALUES('c024fpSriZe2Q8CqbnIupw', 'Z2rn1sK6D0ThX84753iK/A', 'Civil Status', 'Civil status as recognized by law');


INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('GX0IJdt9NViXE2AosyE4nw', '1', 'Male');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('GX0IJdt9NViXE2AosyE4nw', '2', 'Female');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('Or8o41m1xyq/AC5M7G3alg', '1', 'On');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('Or8o41m1xyq/AC5M7G3alg', '2', 'Off');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('VNXzTfBiIzfarqMVf0pIhw', '1', 'TRUE');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('VNXzTfBiIzfarqMVf0pIhw', '2', 'FALSE');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('SFmH6x5A+dfVScLkUI/eLg', '1', 'M');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('SFmH6x5A+dfVScLkUI/eLg', '2', 'F');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('PgnxgHCec02WldxcjlKgnw', '1', 'Yes');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('PgnxgHCec02WldxcjlKgnw', '2', 'No');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('MYxwtlj0ofxGOZjtemv7tQ', '1', 'Y');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('MYxwtlj0ofxGOZjtemv7tQ', '2', 'N');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('c024fpSriZe2Q8CqbnIupw', '1', 'Single');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('c024fpSriZe2Q8CqbnIupw', '2', 'Married');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('c024fpSriZe2Q8CqbnIupw', '3', 'Divorced');
INSERT INTO `table_fields_predefined_list_items`(List_ID, Number, List_Item) VALUES('c024fpSriZe2Q8CqbnIupw', '4', 'Widow/Widower');


