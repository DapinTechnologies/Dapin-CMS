<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $faculties = DB::table('faculties')->pluck('id', 'slug');

        $programs = [

            // Faculty of Arts and Social Sciences
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Sociology', 'shortcode' => 'BA-SOC'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Political Science', 'shortcode' => 'BA-PS'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Literature', 'shortcode' => 'BA-LIT'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in History', 'shortcode' => 'BA-HIST'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Psychology', 'shortcode' => 'BA-PSY'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Anthropology', 'shortcode' => 'BA-ANTH'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Linguistics', 'shortcode' => 'BA-LING'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Philosophy', 'shortcode' => 'BA-PHIL'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in Gender Studies', 'shortcode' => 'BA-GS'],
            ['faculty_slug' => 'faculty-of-arts-and-social-sciences', 'title' => 'Bachelor of Arts in International Relations', 'shortcode' => 'BA-IR'],

            // Faculty of Science and Technology
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Physics', 'shortcode' => 'BSc-PHY'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Computer Science', 'shortcode' => 'BSc-CS'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Chemistry', 'shortcode' => 'BSc-CHEM'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Biology', 'shortcode' => 'BSc-BIO'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Mathematics', 'shortcode' => 'BSc-MATH'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Statistics', 'shortcode' => 'BSc-STAT'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Microbiology', 'shortcode' => 'BSc-MICRO'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Biochemistry', 'shortcode' => 'BSc-BIOCHEM'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Actuarial Science', 'shortcode' => 'BSc-ACT'],
            ['faculty_slug' => 'faculty-of-science-and-technology', 'title' => 'Bachelor of Science in Environmental Science', 'shortcode' => 'BSc-ENV'],

            // Faculty of Education
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education (Arts)', 'shortcode' => 'BEd-A'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education (Science)', 'shortcode' => 'BEd-S'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Early Childhood Education', 'shortcode' => 'BEd-ECE'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Special Needs Education', 'shortcode' => 'BEd-SNE'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Guidance and Counselling', 'shortcode' => 'BEd-GC'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Primary Education', 'shortcode' => 'BEd-PE'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Secondary Education', 'shortcode' => 'BEd-SE'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Educational Administration', 'shortcode' => 'BEd-EA'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Curriculum Studies', 'shortcode' => 'BEd-CS'],
            ['faculty_slug' => 'faculty-of-education', 'title' => 'Bachelor of Education in Educational Psychology', 'shortcode' => 'BEd-EP'],

            // Faculty of Engineering and Technology
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Civil Engineering', 'shortcode' => 'BSc-CE'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Mechanical Engineering', 'shortcode' => 'BSc-ME'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Electrical Engineering', 'shortcode' => 'BSc-EE'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Electronics Engineering', 'shortcode' => 'BSc-ELE'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Mechatronic Engineering', 'shortcode' => 'BSc-MECH'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Agricultural Engineering', 'shortcode' => 'BSc-AE'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Industrial Engineering', 'shortcode' => 'BSc-IE'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Chemical Engineering', 'shortcode' => 'BSc-CHE'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Telecommunication Engineering', 'shortcode' => 'BSc-TEL'],
            ['faculty_slug' => 'faculty-of-engineering-and-technology', 'title' => 'Bachelor of Science in Petroleum Engineering', 'shortcode' => 'BSc-PE'],

            // Faculty of Agriculture
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Agronomy', 'shortcode' => 'BSc-AGRO'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Horticulture', 'shortcode' => 'BSc-HORT'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Animal Science', 'shortcode' => 'BSc-ANSC'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Agricultural Extension', 'shortcode' => 'BSc-AEXT'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Soil Science', 'shortcode' => 'BSc-SOIL'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Agricultural Economics', 'shortcode' => 'BSc-AGRI-ECO'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Agribusiness Management', 'shortcode' => 'BSc-ABM'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Food Science and Technology', 'shortcode' => 'BSc-FST'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Biotechnology', 'shortcode' => 'BSc-BIOTECH'],
            ['faculty_slug' => 'faculty-of-agriculture', 'title' => 'Bachelor of Science in Crop Protection', 'shortcode' => 'BSc-CP'],

            // Faculty of Law
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Laws (LLB)', 'shortcode' => 'LLB'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Criminology and Criminal Justice', 'shortcode' => 'BA-CCJ'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Forensic Science', 'shortcode' => 'BA-FOR'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Legal Studies', 'shortcode' => 'BA-LEG'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Peace and Conflict Studies', 'shortcode' => 'BA-PCS'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in International Law', 'shortcode' => 'BA-ILAW'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Human Rights', 'shortcode' => 'BA-HR'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Public Administration and Policy', 'shortcode' => 'BA-PAP'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Intelligence and Security Studies', 'shortcode' => 'BA-ISS'],
            ['faculty_slug' => 'faculty-of-law', 'title' => 'Bachelor of Arts in Correctional Studies', 'shortcode' => 'BA-COR'],

            // Faculty of Medicine and Health Sciences
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Medicine and Bachelor of Surgery (MBChB)', 'shortcode' => 'MBChB'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Science in Medical Laboratory Science', 'shortcode' => 'BSc-MLS'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Science in Public Health', 'shortcode' => 'BSc-PH'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Dental Surgery', 'shortcode' => 'BDS'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Pharmacy', 'shortcode' => 'BPharm'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Science in Radiography', 'shortcode' => 'BSc-RAD'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Clinical Medicine', 'shortcode' => 'BCM'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Science in Physiology', 'shortcode' => 'BSc-PHYSL'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Science in Biomedical Science', 'shortcode' => 'BSc-BMS'],
            ['faculty_slug' => 'faculty-of-medicine-and-health-sciences', 'title' => 'Bachelor of Science in Occupational Therapy', 'shortcode' => 'BSc-OT'],

            // Faculty of Veterinary Medicine
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Veterinary Medicine', 'shortcode' => 'BVM'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Animal Health', 'shortcode' => 'BSc-AH'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Wildlife Health', 'shortcode' => 'BSc-WH'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Veterinary Technology', 'shortcode' => 'BSc-VT'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Aquatic Animal Health', 'shortcode' => 'BSc-AAH'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Parasitology', 'shortcode' => 'BSc-PARA'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Veterinary Public Health', 'shortcode' => 'BSc-VPH'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Veterinary Pathology', 'shortcode' => 'BSc-VPATH'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Veterinary Pharmacology', 'shortcode' => 'BSc-VPHAR'],
            ['faculty_slug' => 'faculty-of-veterinary-medicine', 'title' => 'Bachelor of Science in Veterinary Microbiology', 'shortcode' => 'BSc-VMICRO'],

            // Faculty of Business and Management Sciences
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Commerce in Accounting', 'shortcode' => 'BCom-ACC'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Commerce in Finance', 'shortcode' => 'BCom-FIN'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Commerce in Marketing', 'shortcode' => 'BCom-MKT'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Commerce in Human Resource Management', 'shortcode' => 'BCom-HRM'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Business Administration', 'shortcode' => 'BBA'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Science in Procurement and Logistics', 'shortcode' => 'BSc-PLM'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Commerce in Entrepreneurship', 'shortcode' => 'BCom-ENT'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Commerce in Business Analytics', 'shortcode' => 'BCom-BA'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Science in Project Management', 'shortcode' => 'BSc-PM'],
            ['faculty_slug' => 'faculty-of-business-and-management-sciences', 'title' => 'Bachelor of Commerce in Risk Management', 'shortcode' => 'BCom-RM'],

            // Faculty of Computing and Informatics
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Information Technology', 'shortcode' => 'BSc-IT'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Software Engineering', 'shortcode' => 'BSc-SE'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Data Science', 'shortcode' => 'BSc-DS'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Artificial Intelligence', 'shortcode' => 'BSc-AI'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Cyber Security', 'shortcode' => 'BSc-CYBER'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Cloud Computing', 'shortcode' => 'BSc-CLOUD'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Computer Engineering', 'shortcode' => 'BSc-CEG'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Web and Mobile Computing', 'shortcode' => 'BSc-WMC'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Networking', 'shortcode' => 'BSc-NET'],
            ['faculty_slug' => 'faculty-of-computing-and-informatics', 'title' => 'Bachelor of Science in Health Informatics', 'shortcode' => 'BSc-HI'],

            // Faculty of Environmental Studies
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Environmental Planning and Management', 'shortcode' => 'BEPM'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Environmental Studies in Climate Change', 'shortcode' => 'BES-CC'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Science in Natural Resource Management', 'shortcode' => 'BSc-NRM'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Environmental Science in Wildlife Management', 'shortcode' => 'BES-WLM'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Science in Environmental Health', 'shortcode' => 'BSc-EH'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Science in Geography', 'shortcode' => 'BSc-GEO'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Science in Environmental Engineering', 'shortcode' => 'BSc-EENG'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Science in Urban and Regional Planning', 'shortcode' => 'BSc-URP'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Science in Sustainability Studies', 'shortcode' => 'BSc-SS'],
            ['faculty_slug' => 'faculty-of-environmental-studies', 'title' => 'Bachelor of Science in Environmental Conservation', 'shortcode' => 'BSc-EC'],

        ];

        foreach ($programs as &$program) {
            $program['faculty_id'] = $faculties[$program['faculty_slug']] ?? null;
            $program['slug'] = Str::slug($program['title']);
            unset($program['faculty_slug']);
        }

        DB::table('programs')->insert($programs);
    }
}
