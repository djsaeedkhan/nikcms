<?php
namespace Lms\Controller;
use App\Controller\AppController as BaseController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class AppController extends BaseController
{
    public $setting;
    public function initialize(){
        parent::initialize();
        $this->LmsCourses = TableRegistry::getTableLocator()->get('Lms.LmsCourses');
        $this->LmsCourseweeks = TableRegistry::getTableLocator()->get('Lms.LmsCourseweeks');
        $this->LmsCoursesessions = TableRegistry::getTableLocator()->get('Lms.LmsCoursesessions');
        $this->LmsCoursefiles = TableRegistry::getTableLocator()->get('Lms.LmsCoursefiles');
        $this->LmsCoursefilecans = TableRegistry::getTableLocator()->get('Lms.LmsCoursefilecans');
        $this->LmsCoursefilenotes = TableRegistry::getTableLocator()->get('Lms.LmsCoursefilenotes');
        $this->LmsCourseusers = TableRegistry::getTableLocator()->get('Lms.LmsCourseusers');
        $this->LmsCourserelateds = TableRegistry::getTableLocator()->get('Lms.LmsCourserelateds');
        $this->LmsCourseexams = TableRegistry::getTableLocator()->get('Lms.LmsCourseexams');
        $this->LmsCoursecategories = TableRegistry::getTableLocator()->get('Lms.LmsCoursecategories');

        $this->LmsExams = TableRegistry::getTableLocator()->get('Lms.LmsExams');
        $this->LmsExamquests = TableRegistry::getTableLocator()->get('Lms.LmsExamquests');
        $this->LmsExamusers = TableRegistry::getTableLocator()->get('Lms.LmsExamusers');
        $this->LmsExamresults = TableRegistry::getTableLocator()->get('Lms.LmsExamresults');
        $this->LmsExamresultlists = TableRegistry::getTableLocator()->get('Lms.LmsExamresultlists');
        
        $this->LmsFactors = TableRegistry::getTableLocator()->get('Lms.LmsFactors');
        $this->LmsCoupons = TableRegistry::getTableLocator()->get('Lms.LmsCoupons');
        $this->LmsPayments = TableRegistry::getTableLocator()->get('Lms.LmsPayments');
        
        $this->LmsUserfactors = TableRegistry::getTableLocator()->get('Lms.LmsUserfactors');
        $this->Users = TableRegistry::getTableLocator()->get('Lms.Users');
        $this->ViewBuilder()->setLayout('Admin.default');
        

        $this->setting = TableRegistry::getTableLocator()->get('Admin.Options')
            ->find('list',['keyField'=>'name','valueField'=>'value'])
            ->where(['name' => 'plugin_lms'])
            ->toArray();
        $this->setting = isset($this->setting['plugin_lms'])? unserialize($this->setting['plugin_lms']) :[];

        $this->set([
            'plugin_lms'=> $this->setting,
            'code' => 1,
            'coursefilenotes_type'=>[
                1 =>'متنی',
                2 =>'دانلود فایل',
                3 =>'تصویر',
                4 =>'لینک',
            ],
            'lms_examquests_type'=>[
                0 =>'متنی تشریحی (Text)',
                1 =>'یک انتخابی (Radio)',
                //2 =>'چند انتخابی (Checkbox)',
            ],
            'guser_id' => $this->Auth->user('id'),
        ]);
    }
}