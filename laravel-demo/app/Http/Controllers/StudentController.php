<?php
namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller{

    public function index()
    {
//        $students = Student::get();
        $students = Student::paginate(10);
//        dd($students->links());
        return view('student.index',['students'=>$students]);
    }

    public function create(Request $request)
    {
        $student = new Student();
        if($request->isMethod('POST')){

            //$this指当前控制器,:attribute为占位符
            //1.控制器验证
            /*
            $this->validate($request,[
                'Student.name'=>'required|min:2|max:20',
                'Student.age'=>'required|integer',
                'Student.sex'=>'required|integer'
            ],[
                'required'=>':attribute 为必填项！',
                'min'=>':attribute 至少为2个字符！',
                'max'=>':attribute 至多为20个字符！',
                'integer'=>':attribute 只能为整形！'
            ],[
                'Student.name'=>'姓名',
                'Student.age'=>'年龄',
                'Student.sex'=>'性别'
            ]);
            */

            //validator类验证
           $validator = \Validator::make($request->input(),[
                'Student.name'=>'required|min:2|max:20',
                'Student.age'=>'required|integer',
                'Student.sex'=>'required|integer'
            ],[
                'required'=>':attribute 为必填项！',
                'min'=>':attribute 至少为2个字符！',
                'max'=>':attribute 至多为20个字符！',
                'integer'=>':attribute 只能为整形！'
            ],[
                'Student.name'=>'姓名',
                'Student.age'=>'年龄',
                'Student.sex'=>'性别'
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->input('Student');
            if(Student::create($data)){//调用create的时候会使用批量复制，要现在模型设置好
                return redirect('student/index')->with('success','添加成功');
            }else{
                return redirect()->back();
            }
        }
        return view('student.create',['student'=>$student]);
    }

    public function save(Request $request)
    {
       $data = $request->input('Student');
//        var_dump($data);
        $student = new Student();
        $student -> name = $data['name'];
        $student -> age = $data['age'];
        $student -> sex = $data['sex'];
        if($student->save()){
            return redirect('student/index');
        }else{
            return redirect()->back();
        }
    }

    public function update($id,Request $request)
    {
        $student = Student::find($id);

        if($request->ismethod('POST')){

            $this->validate($request,[
                'Student.name'=>'required|min:2|max:20',
                'Student.age'=>'required|integer',
                'Student.sex'=>'required|integer'
            ],[
                'required'=>':attribute 为必填项！',
                'min'=>':attribute 至少为2个字符！',
                'max'=>':attribute 至多为20个字符！',
                'integer'=>':attribute 只能为整形！'
            ],[
                'Student.name'=>'姓名',
                'Student.age'=>'年龄',
                'Student.sex'=>'性别'
            ]);

            $data = $request -> input('Student');
            $student->name = $data['name'];
            $student->age = $data['age'];
            $student->sex = $data['sex'];

            if($student->save()){
                return redirect('student/index')->with('success','修改成功-'.$id);
            }
        }

        return view('student.update',['student'=>$student]);
    }

    public function detail($id)
    {
        $student = Student::find($id);
        return view('student.detail',['student'=>$student]);
    }

    public function delete($id)
    {

        $student = Student::find($id);
        if($student->delete()){
            return redirect('student/index')->with('success','删除成功-'.$id);
        }else{
            return redirect('student/index')->with('error','删除失败-'.$id);
        }

    }

}