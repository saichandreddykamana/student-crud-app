<template>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 m-2">
          <div class="card">
            <div class="card-header">Add / Edit New Student</div>
            <div class="card-body">
                <form @submit.prevent="modifyStudent">
                  <div class="form-group">
                    <input type="number" class="form-control" id="student_id" v-model="student.student_id" readonly>
                  </div>
                  <div class="form-group">
                    <label for="surname">Surname</label>
                    <input type="text" class="form-control" id="surname" v-model="student.surname" placeholder="Enter Student Surname" required maxlength="100">
                  </div>
                  <div class="form-group">
                    <label for="forename_1">Forename 1</label>
                    <input type="text" class="form-control" id="forename_1" v-model="student.forename_1" placeholder="Enter Student Forename 1" maxlength="100">
                  </div>
                  <div class="form-group">
                    <label for="forname_2">Forename 2</label>
                    <input type="text" class="form-control" id="forename_2" v-model="student.forename_2" placeholder="Enter Student Forename 2" maxlength="100">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" v-model="student.email" placeholder="Enter your student email" required maxlength="255">
                  </div>
                  <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" class="form-control" id="username" v-model="student.username" placeholder="Enter your student username" required maxlength="6">
                  </div>
                  <div class="form-group mt-5 d-flex">
                    <div class="form-check m-1">
                      <input class="form-check-input" type="radio" name="gender" id="male" value="Male" v-model="student.gender" checked >
                      <label class="form-check-label" for="male">
                        Male
                      </label>
                    </div>
                    
                    <div class="form-check m-1">
                      <input class="form-check-input" type="radio" name="gender" id="female" v-model="student.gender" value="Female">
                      <label class="form-check-label" for="female">
                        Female
                      </label>
                    </div>
                    
                    <div class="form-check m-1">
                      <input class="form-check-input" type="radio" name="gender" id="other"   v-model="student.gender" value="Other" >
                      <label class="form-check-label" for="other">
                        Other
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="student_dob">Date of Birth</label>
                    <input type="date" class="form-control" id="student_dob" v-model="student.date_of_birth" required >
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Add/Update Student</button>
                </form>
            </div>
          </div>
        </div>
  
        <div class="col-md-8 m-2">
          <div class="card">
            <div class="card-header">Students List</div>
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                  <tr >
                    <th >Student Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="student in students" :key="student.student_id">
                    <td>{{ student.student_id }}</td>
                    <td>{{ student.surname }} {{ student.forename_1 }} {{ student.forename_2 }}</td>
                    <td>{{ student.email }}</td>
                    <td>  
                      <button class="btn btn-primary btn-sm m-1" @click="editStudent(student.student_id)">Edit</button>
                      <button class="btn btn-danger btn-sm m-1" @click="deleteStudent(student.student_id)">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    name: 'UserDashboard',
    data() {
      return {
        student: {
          student_id: '',
          surname: '',
          forename_1: '',
          forename_2: '',
          email: '',
          username: '',
          gender: '',
          date_of_birth: '',
        },
        students: [],
      };
    },

    methods: {
      getAllStudents() {
        const axiosInstance = axios.create({
              headers: {
                'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
                'Content-Type': 'application/json', 
              },
        });
        axiosInstance.get('http://127.0.0.1:8000/api/students')
          .then((response) => {
            this.students = response.data.students;
          })
      },

      addStudent() {
        // Handle form submission, for now, log the form data
        console.log('Form submitted:', this.student);
      },

      editStudent(student_id) {
        const axiosInstance = axios.create({
              headers: {
                'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
                'Content-Type': 'application/json', 
              },
        });
        axiosInstance.get(`http://127.0.0.1:8000/api/students/0${student_id}`)
          .then((response) => {
            this.student = response.data.student;
            console.log(this.student);
            this.student.date_of_birth = new Date(this.student.date_of_birth).toISOString().split('T')[0];
          })
      },
      deleteStudent(student_id){
          const axiosInstance = axios.create({
                  headers: {
                    'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
                    'Content-Type': 'application/json', 
                  },
          });

        axiosInstance.delete(`http://127.0.0.1:8000/api/students/0${student_id}`);
        this.getAllStudents();
      },

      modifyStudent() {
        if(this.student.student_id != ''){
          this.updateStudent(this.student.student_id);
        }else{
          this.addStudent();
        }
      },
      updateStudent(student_id){
      const axiosInstance = axios.create({
              headers: {
                'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
                'Content-Type': 'application/json', // You can adjust this based on your API requirements
              },
        });
        axiosInstance.put(`http://127.0.0.1:8000/api/students/0${student_id}`, this.student)
          .then(() => {
            this.student = {};
            this.getAllStudents();
          })
    }
    },

    mounted() {
      this.getAllStudents();
    }
  };
  </script>
  
  <style scoped>
  .container-fluid {
    padding: 0;
  }
  </style>
  