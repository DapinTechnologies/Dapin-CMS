<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            // Arts and Social Sciences
            [
                'title' => 'Introduction to Sociology',
                'code' => 'SOC101',
                'credit_hour' => 3,
                'subject_type' => 1, // Compulsory
                'class_type' => 1,   // Theory
                'total_marks' => 100,
                'passing_marks' => 40,
                'description' => 'Basic concepts and theories of sociology',
                'status' => 1,
            ],
            [
                'title' => 'Political Science Fundamentals',
                'code' => 'PS101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 40,
                'description' => 'Introduction to political systems and ideologies',
                'status' => 1,
            ],

            // Science and Technology
            [
                'title' => 'General Physics',
                'code' => 'PHY101',
                'credit_hour' => 4,
                'subject_type' => 1,
                'class_type' => 3, // Both theory and practical
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Fundamentals of mechanics, waves and thermodynamics',
                'status' => 1,
            ],
            [
                'title' => 'Introduction to Computer Science',
                'code' => 'CS101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Basics of programming, algorithms and data structures',
                'status' => 1,
            ],

            // Engineering
            [
                'title' => 'Engineering Mathematics',
                'code' => 'ENGM101',
                'credit_hour' => 4,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Mathematical tools for engineering',
                'status' => 1,
            ],
            [
                'title' => 'Circuit Theory',
                'code' => 'ENGC101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 3,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Basic electrical circuits and components',
                'status' => 1,
            ],

            // Medicine and Health Sciences
            [
                'title' => 'Anatomy and Physiology',
                'code' => 'MED101',
                'credit_hour' => 4,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Human body structure and function',
                'status' => 1,
            ],
            [
                'title' => 'Medical Biochemistry',
                'code' => 'MED102',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Chemical processes in the human body',
                'status' => 1,
            ],

            // Business and Management
            [
                'title' => 'Principles of Accounting',
                'code' => 'ACC101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Basics of financial and management accounting',
                'status' => 1,
            ],
            [
                'title' => 'Introduction to Marketing',
                'code' => 'MKT101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Marketing principles and strategies',
                'status' => 1,
            ],

            // Education
            [
                'title' => 'Foundations of Education',
                'code' => 'EDU101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 40,
                'description' => 'Historical and philosophical foundations of education',
                'status' => 1,
            ],
            [
                'title' => 'Curriculum Development',
                'code' => 'EDU102',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 40,
                'description' => 'Principles and methods of curriculum design',
                'status' => 1,
            ],

            // Computing and Informatics
            [
                'title' => 'Data Structures and Algorithms',
                'code' => 'CS201',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Organizing and manipulating data efficiently',
                'status' => 1,
            ],
            [
                'title' => 'Database Systems',
                'code' => 'CS202',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Relational databases, SQL and design principles',
                'status' => 1,
            ],

            // Agriculture
            [
                'title' => 'Crop Production',
                'code' => 'AGR101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 2, // Practical
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Principles and methods of crop farming',
                'status' => 1,
            ],
            [
                'title' => 'Soil Science',
                'code' => 'AGR102',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Soil properties and management',
                'status' => 1,
            ],

            // Law
            [
                'title' => 'Introduction to Law',
                'code' => 'LAW101',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Fundamental principles and sources of law',
                'status' => 1,
            ],
            [
                'title' => 'Constitutional Law',
                'code' => 'LAW102',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 1,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Kenyan constitutional framework and human rights',
                'status' => 1,
            ],

            // Nursing
            [
                'title' => 'Fundamentals of Nursing',
                'code' => 'NUR101',
                'credit_hour' => 4,
                'subject_type' => 1,
                'class_type' => 3,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Basic nursing principles and skills',
                'status' => 1,
            ],
            [
                'title' => 'Community Health Nursing',
                'code' => 'NUR102',
                'credit_hour' => 3,
                'subject_type' => 1,
                'class_type' => 2,
                'total_marks' => 100,
                'passing_marks' => 50,
                'description' => 'Public health nursing and community care',
                'status' => 1,
            ],
        ];

        DB::table('subjects')->insert($subjects);
    }
}
