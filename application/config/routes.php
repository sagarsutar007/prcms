<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['about'] = 'welcome/about';
$route['team'] = 'welcome/team';
$route['contact'] = 'welcome/contact';
$route['logout'] = 'login/logout';
$route['candidate/forgot-password'] = 'login/forgotPassword/candidate';
$route['candidate/reset-password'] = 'login/resetPassword';

$route['client/forgot-password'] = 'login/forgotPassword/client';
$route['client/reset-password'] = 'login/resetPassword';

$route['business/forgot-password'] = 'login/forgotPassword/business';
$route['business/reset-password'] = 'login/resetPassword';

$route['admin/forgot-password'] = 'login/forgotPassword/admin';
$route['admin/reset-password'] = 'login/resetPassword';

$route['client-signup'] = 'signup/client';
$route['candidate-signup'] = 'signup';
$route['my-account'] = 'settings/myAccount';
$route['candidate-signup/update-address'] = 'signup/updateCandidateAddress';
$route['candidate-signup/update-bank'] = 'signup/updateCandidateBank';
$route['candidate-signup/update-house'] = 'signup/updateCandidateHouse';
$route['candidate-signup/update-other'] = 'signup/updateCandidateOther';
$route['registration-complete'] = 'signup/regComplete';
$route['update-profile-image'] = 'login/updateProfilePhoto';

$route['client-login'] = 'Login/client';
$route['admin-login'] = 'Login/admin';
$route['business-login'] = 'Login/businessUnit';
$route['candidate-login'] = 'Login/candidate';

$route['qr-codes'] = 'Qrcodes';

$route['business-units'] = 'BusinessUnits';
$route['business-units/(:num)'] = 'BusinessUnits/$1';
$route['business-units/create'] = 'BusinessUnits/create';
$route['business-units/view/(:num)'] = 'BusinessUnits/view/$1';
$route['business-units/edit/(:num)'] = 'BusinessUnits/edit/$1';
$route['business-units/delete/(:num)'] = 'BusinessUnits/delete/$1';
$route['business-units/delete-selected'] = 'BusinessUnits/deleteMultiple';

$route['business-units/managers'] = 'Managers';
$route['business-units/managers/(:num)'] = 'Managers/$1';
$route['business-units/manager/create'] = 'Managers/create';
$route['business-units/manager/view/(:num)'] = 'Managers/view/$1';
$route['business-units/manager/edit/(:num)'] = 'Managers/edit/$1';
$route['business-units/manager/delete/(:num)'] = 'Managers/delete/$1';
$route['business-units/managers/delete-selected'] = 'Managers/deleteMultiple';

$route['clients'] = 'Clients';
$route['clients/(:num)'] = 'Clients/$1';
$route['client/create'] = 'Clients/create';
$route['client/view/(:num)'] = 'Clients/view/$1';
$route['client/edit/(:num)'] = 'Clients/edit/$1';
$route['client/delete/(:num)'] = 'Clients/delete/$1';
$route['clients/delete-selected'] = 'Clients/deleteMultiple';

$route['candidates'] = 'Candidates';
$route['candidates/(:num)'] = 'Candidates/$1';
$route['candidate/create'] = 'Candidates/create';
$route['candidate/view/(:num)'] = 'Candidates/view/$1';
$route['candidate/print/(:num)'] = 'Candidates/print/$1';
$route['candidate/edit/(:num)'] = 'Candidates/edit/$1';
$route['candidate/delete/(:num)'] = 'Candidates/delete/$1';
$route['candidates/delete-selected'] = 'Candidates/deleteMultiple';
$route['candidate/view-exam-result'] = 'Candidates/viewExamResult';
$route['candidate/generate-candidate-result'] = 'Candidates/generateDetailedResult';
$route['candidate/bulk-upload'] = 'Candidates/bulkUpload';
$route['candidates/send-login-mail'] = 'Candidates/sendLoginMail';
$route['candidates/send-login-sms'] = 'Candidates/sendLoginSms';
$route['candidates/filter'] = 'Candidates/filter';
$route['candidate/search-candidate'] = 'Candidates/searchCandidate';

$route['question-bank/categories'] = 'Categories';
$route['question-bank/categories/(:num)'] = 'Categories/$1';
$route['question-bank/category/create'] = 'Categories/create';
$route['question-bank/category/view/(:num)'] = 'Categories/view/$1';
$route['question-bank/category/edit/(:num)'] = 'Categories/edit/$1';
$route['question-bank/category/delete/(:num)'] = 'Categories/delete/$1';
$route['question-bank/categories/delete-selected'] = 'Categories/deleteMultiple';

$route['question-bank'] = 'QuestionBank';
$route['question-bank/(:num)'] = 'QuestionBank/$1';
$route['question-bank/view/(:num)'] = 'QuestionBank/view/$1';
$route['question-bank/create'] = 'QuestionBank/create';
$route['question-bank/edit/(:num)'] = 'QuestionBank/edit/$1';
$route['question-bank/delete/(:num)'] = 'QuestionBank/delete/$1';
$route['question-bank/delete-selected'] = 'QuestionBank/deleteMultiple';
$route['question-bank/print'] = 'QuestionBank/generatePdf';
$route['question-bank/fetch-category-selected-quesions'] = 'QuestionBank/fetchMultiCategoryQuestions';
$route['question-bank/remove-exam-question'] = 'QuestionBank/removeExamQuestion';
$route['question-bank/remove-question-image'] = 'QuestionBank/removeQuestionImage';

$route['exam/create'] = 'Exams/create';
$route['exam/edit/(:num)'] = 'Exams/edit/$1';
$route['exam/delete/(:num)'] = 'Exams/delete/$1';
$route['exam/clone/(:num)'] = 'Exams/clone/$1';
$route['exam/(:num)/add-questions'] = 'Exams/addQuestions/$1';
$route['exam/(:num)/add-candidates'] = 'Exams/addCandidates/$1';
$route['exam/(:num)/edit-questions'] = 'Exams/editQuestions/$1';
$route['exam/(:num)/edit-candidates'] = 'Exams/editCandidates/$1';
$route['exam/(:num)/exam-settings'] = 'Exams/editSettings/$1';
$route['exam/(:num)/change-candidates-password'] = 'Exams/changeCandidatesPassword/$1';
$route['exam/(:num)/stop-exam'] = 'Exams/stopExam/$1';
$route['exam/(:num)/start-exam-repair'] = 'Exams/startExamRepair/$1';
$route['exam/(:num)/repair-exam-candidates'] = 'Exams/RepairExamCandidates/$1';
$route['exam/insert-candidate-to-exam'] = 'Exams/insertExamCandidate';
$route['exam/remove-candidate-from-exam'] = 'Exams/removeExamCandidate';
$route['exams/upcoming'] = 'Exams/upcomingExam';
$route['exams/completed'] = 'Exams/completedExam';
$route['exams/ongoing'] = 'Exams/ongoingExam';
$route['exams/(:any)/begin'] = 'Exams/showExamStartScreen/$1';
$route['exams/(:any)/exam'] = 'Exams/showQuestionScreen/$1';
$route['exams/(:num)/view-result'] = 'Exams/viewResult/$1';
$route['exams/(:num)/view-detailed-result'] = 'Exams/viewDetailedResult/$1';
$route['exams/(:num)/view-exam-dashboard'] = 'Exams/viewExamDashboard/$1';
$route['exams/(:num)/schedule-exam'] = 'Exams/scheduleExam/$1';
$route['exams/(:num)/download-excel-format'] = 'Exams/downloadExcel/$1';
$route['exams/(:num)/download-results-pdf'] = 'Exams/downloadResults/$1';
$route['exams/download-exam-candidate/(:num)'] = 'Exams/generateExamCandidatePdf/$1';
$route['exams/delete-selected'] = 'Exams/deleteMultiple';
$route['exams/add-selected-candidates'] = 'Exams/addSelectedCandidates';
$route['exams/remove-selected-candidates'] = 'Exams/removeSelectedCandidates';
$route['exams/(:num)/download-paper'] = 'Exams/downloadPaper/$1';
$route['exams/enable-rentry'] = 'Exams/enableRentry';

$route['settings/change-password'] = 'Settings/changePassword';
$route['settings/sms-templates'] = 'Settings/smsTemplates';
$route['settings/email-templates'] = 'Settings/emailTemplates';
$route['settings/profile/verify-otp'] = 'Settings/verifyOTP';

$route['delivery-report'] = 'Notifications';

$route['e/(:any)'] = 'Login/candidate/$1';



