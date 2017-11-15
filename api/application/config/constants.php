<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define("MAX_SIZE_UPLOAD",50000000);
define('MAX_WIDTH_UPLOAD',50000000);
define('MAX_HEIGHT_UPLOAD',50000000);

//Masters Module
define('MODULROLE',1);
define('MODULUSER',2);
define('MODULPROJECT',3);
define('MODULTASK',4);
define('MODULCOMMENT',5);
define('MODULTASKTYPE',6);
define('MODULTASKSTATUS',7);
define('MODULTASKSEVERITY',8);
define('MODULTASKRESOLUTION',9);
define('MODULTASKCATEGORIES',10);
define('MODULNEWS',12);
define('MODULVERSIONS',13);

//Others Module
define('OTHERMODUL_CANCLOSETASK',1);
define('OTHERMODUL_CANLOOKALLTASKASSIGN',2);
define('OTHERMODUL_CANCHANGEASSIGN',3);
define('OTHERMODUL_CANCHANGEPERCENTASE',4);
define('OTHERMODUL_CANCAHANGESTATUS',5);
define('OTHERMODUL_CANEDITTASKANOTHERUSER',6);
define('OTHERMODUL_SETSTATUS_NEW',7);
define('OTHERMODUL_SETSTATUS_UNCONFIRMED',8);
define('OTHERMODUL_SETSTATUS_ASSIGNED',9);
define('OTHERMODUL_SETSTATUS_RESEARCHING',10);
define('OTHERMODUL_SETSTATUS_WAITINGCUSTOMER',11);
define('OTHERMODUL_SETSTATUS_REQUIRETESTING',12);
define('OTHERMODUL_ONLYLOOKOWNTASK',13);
define('OTHERMODUL_CANLOOKREPORT',14);
define('OTHERMODUL_CANCHANGE_STARTDATE',15);
define('OTHERMODUL_CANEDIT_ANOTHERCOMMENT',16);
define('OTHERMODUL_CANDELETE_ANOTHERCOMMENT',17);
define('OTHERMODUL_SELECT_COMMENTTYPE',18);
define('OTHERMODUL_SHOW_TESTERTASK',19);
define('OTHERMODUL_SETSTATUS_CHECKING',20);
define('OTHERMODUL_SETSTATUS_CHECKED',21);
define('OTHERMODUL_SHOW_CHECKINGREPORT',22);

//role
define('ADMINROLE',1);
define('USERROLE',2);
define('UNLOGINROLE',3);

//view
define('VIEW_ROLEADD', 'role/add');
define('VIEW_ROLEEDIT', 'role/edit');
define('VIEW_MEDIADATA', 'media/data');
define('VIEW_MEDIASELECT', 'media/select');
define('VIEW_MEDIAMULTISELECT', 'media/multiselect');
define('VIEW_MEDIAEDIT', 'media/edit');
define('VIEW_MEDIAOLD_ADDBULK', 'media/old-addbulk');
define('VIEW_MEDIAUPLOADIFY', 'media/uploadify');
define('VIEW_MEDIAWATERMARK', 'media/watermark');
define('VIEW_MEDIAROTASI', 'media/rotasi');
define('VIEW_MEDIACROP', 'media/crop');

//table
define('TBL_USERS', 'users');
define('TBL_ROLES', 'roles');
define('TBL_PROJECTS', 'projects');
define('TBL_CATEGORIES', 'categories');
define('TBL_TASKRESOLUTIONS', 'taskresolutions');
define('TBL_TASKTYPES', 'tasktypes');
define('TBL_TASKSTATUS', 'taskstatus');
define('TBL_ATTACHMENTS', 'attachments');
define('TBL_COMMENTS', 'comments');
define('TBL_COMMENTTYPES', 'commenttypes');
define('TBL_MODULES', 'modules');
define('TBL_TASKASSIGNMENTS', 'taskassignments');
define('TBL_TASKPRIORITIES', 'taskpriorities');
define('TBL_TASKSEVERITIES', 'taskseverities');
define('TBL_TASKS', 'tasks');
define('TBL_OTHERMODULES', 'othermodules');
define('TBL_ROLEPRIVILEGES', 'roleprivileges');
define('TBL_ROLEOTHERMODULES', 'roleothermodules');
define('TBL_NEWS','news');
define('TBL_VERSIONS','versions');
define('TBL_TASKFAVORITE', 'taskfavorite');

//Colom
define('COL_ROLENAME', 'RoleName');
define('COL_USERNAME', 'UserName');
define('COL_PASSWORD', 'Password');
define('COL_ROLEID', 'RoleID');
define('COL_LASTLOGIN', 'LastLogin');
define('COL_LASTIPADDRESS', 'LastIPAddress');
define('COL_ISSUSPEND', 'IsSuspend');
define('COL_CATEGORYID', 'CategoryID');
define('COL_CATEGORYNAME', 'CategoryName');
define('COL_PARENTCATEGORYID', 'ParentCategoryID');
define('COL_PROJECTNAME', 'ProjectName');
define('COL_ISANYONECANVIEW', 'IsAnyoneCanView');
define('COL_ISANYONECANADDTASK', 'IsAnyoneCanAddTask');
define('COL_ISACTIVE', 'IsActive');
define('COL_ISNOTIFONREPLY', 'IsNotifOnReply');
define('COL_ISCOMMENTCLOSED', 'IsCommentClosed');
define('COL_CREATEDON', 'CreatedOn');
define('COL_CREATEDBY', 'CreatedBy');
define('COL_UPDATEON', 'UpdateOn');
define('COL_UPDATEBY', 'UpdateBy');
define('COL_TASKRESOLUTIONID', 'TaskResolutionID');
define('COL_TASKRESOLUTIONNAME', 'TaskResolutionName');
define('COL_ORDER', 'Order');
define('COL_TASKSTATUSID', 'TaskStatusID');
define('COL_TASKSTATUSNAME', 'TaskStatusName');
define('COL_TASKTYPEID', 'TaskTypeID');
define('COL_TASKTYPENAME', 'TaskTypeName');
define('COL_TASKID', 'TaskID');
define('COL_PROJECTID', 'ProjectID');
define('COL_TASKPRIORITYID', 'TaskPriorityID');
define('COL_SUMMARY', 'Summary');
define('COL_DESCRIPTION', 'Description');
define('COL_PERCENTCOMPLETE', 'PercentComplete');
define('COL_ISPRIVATE', 'IsPrivate');
define('COL_TASKSEVERITYID', 'TaskSeverityID');
define('COL_STARTEDDATE', 'StartedDate');
define('COL_DUEDATE', 'DueDate');
define('COL_ISCLOSED', 'IsClosed');
define('COL_CLOSEDBY', 'ClosedBy');
define('COL_CLOSEDON', 'ClosedOn');
define('COL_ATTACHMENTID', 'AttachmentID');
define('COL_REFERENCEID', 'ReferenceID');
define('COL_FILENAME', 'FileName');
define('COL_FILETYPE', 'FileType');
define('COL_FILESIZE', 'FileSize');
define('COL_UPLOADBY', 'UploadBy');
define('COL_UPLOADON', 'UploadOn');
define('COL_MODULEID', 'ModuleID');
define('COL_MODULENAME', 'ModuleName');
define('COL_COMMENTID', 'CommentID');
define('COL_TASKASSIGNMENTID', 'TaskAssignmentID');
define('COL_TASKPRIORITYNAME', 'TaskPriorityName');
define('COL_TASKSEVERITYNAME', 'TaskSeverityName');
define('COL_OTHERMODULEID', 'OtherModuleID');
define('COL_OTHERMODULENAME', 'OtherModuleName');
define('COL_ROLEPRIVILEGEID', 'RolePrivilegeID');
define('COL_INSERT', 'Insert');
define('COL_UPDATE', 'Update');
define('COL_DELETE', 'Delete');
define('COL_VIEW', 'View');
define('COL_CLOSEDMESSAGE', 'ClosedMessage');
define('COL_NEWSID', 'NewsID');
define('COL_NEWSTITLE', 'NewsTitle');
define('COL_EXPIREDDATE', 'ExpiredDate');
define('COL_EMAILADDRESS', 'EmailAddress');
define('COL_VERSIONID', 'VersionID');
define('COL_VERSIONNAME', 'VersionName');
define('COL_COMMENTYPEID', 'CommentTypeID');
define('COL_COMMENTTYPENAME', 'CommentTypeName');
define('COL_ISCHECKED', 'IsChecked');
define('COL_STARTCHECKON', 'StartCheckOn');
define('COL_FINISHCHECKON', 'FinishCheckOn');
define('COL_FINISHMESSAGE', 'FinishMessage');
define('COL_STARTCHECKBY', 'StartCheckBy');
define('COL_FINISHCHECKBY', 'FinishCheckBy');
define('COL_ISCOMPLETED', 'IsCompleted');
define('COL_COMPLETEDON', 'CompletedOn');
define('COL_COMPLETEDBY', 'CompletedBy');
define('COL_COMPLETEMESSAGE', 'CompleteMessage');
define('COL_SWONO', 'SWONo');
define('COL_TASKFAVORITEID', 'TaskFavoriteID');

define('TASKSTATUS_NEW',1);
define('TASKSTATUS_UNCONFIRMED',2);
define('TASKSTATUS_ASSIGNED',3);
define('TASKSTATUS_RESEARCHING',4);
define('TASKSTATUS_WAITINGONCUSTOMER',5);
define('TASKSTATUS_REQUIRESTESTING',6);
define('TASKSTATUS_FINISHED',7);
define('TASKSTATUS_VERIFIED',8);
define('TASKSTATUS_ONTESTING',9);
define('TASKSTATUS_CLOSED',10);

define('TASKTYPE_LAPORAN_CUSTOMER',6);

define('TASK_ISCLOSED',1);

define('SMTP_SENDER', 'noreply@mpssoft.co');
define('SMTP_SENDER_NAME', 'Bugs Management');

define('SUBJECT_EMAIL_TASK', 'Pemberitahuan Tugas');
define('SUBJECT_EMAIL_COMMENT', 'Pemberitahuan Comment');

define('EMAILPROTOCOL','smtp');
define('EMAIL_TEMPLATE', '@MAIN_CONTENT@');

define('FILETYPE_IMAGE', 0);
define('FILETYPE_FILE', 1);
define('FILETYPE_PACKAGE', 2);

define('COMMENTTYPE_GENERAL', 1);
define('COMMENTTYPE_BUG', 2);

define('ADMINMAIL', 'dian@vegatechit.com');
define('ADMINUSERNAME', 'dian');
/* End of file constants.php */
/* Location: ./application/config/constants.php */
