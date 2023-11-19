<template>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8" v-if="errorMsg !== null">
          <div class="alert alert-warning" role="alert">
            <h4>{{ errorMsg }}</h4>
          </div>
        </div>
        <div class="col-md-8" v-if="successMsg !== null">
          <div class="alert alert-success" role="alert">
            <h4>{{ successMsg }}</h4>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 m-2">
          <div class="card">
            <div class="card-header">Add / Edit New Student</div>
            <div class="card-body">
                <form @submit.prevent="modifyStudent">
                  <div class="form-group">
                    <input type="text" class="form-control" id="student_id" v-model="student.student_id" placeholder="Enter Student ID" required maxlength="8" minlength="8" >
                  </div>
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" v-model="student.title" placeholder="Enter Student Title" required maxlength="100">
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
                      <input class="form-check-input" type="radio" name="gender" id="male" value="Male" v-model="student.gender" required >
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
                          <button class="btn btn-success btn-sm m-1" @click="viewStudent(student.student_id)">View</button>
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
    /**
     * Initializes the data for the component.
     *
     * @return {Object} - The initial data for the component.
     */
    data() {
      return {
        student: {
            student_id: '',
            surname: '',
            forename_1: '',
            forename_2: '',
            email: '',
            username: '',
            title: '',
            gender: '',
            date_of_birth: '',
            create: true,
        },
        students: [],
        errorMsg: null,
        successMsg: null
      };
    },

    methods: {
/**
 * Retrieves all students from the API.
 *
 * @returns {undefined}
 */
        getAllStudents() {
          // Create an instance of axios with custom headers
          const axiosInstance = axios.create({
            headers: {
              'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
              'Content-Type': 'application/json', 
            },
          });

          // Send GET request to retrieve students from the API
          axiosInstance.get('http://127.0.0.1:8000/api/students')
            .then((response) => {
              // Extract the students data from the response
              const students = response.data.students.map((student) => {
                // Normalize student IDs to have 8 digits
                if (student.student_id.toString().length < 8) {
                  student.student_id = student.student_id.toString().padStart(8, '0');
                }
                return student;
              });

              // Update the students data in the component state
              this.students = students;
            }).catch((error) => {
              // Handle error by setting error message
              this.errorMsg = error.response.data.message;
            });
        },

/**
 * Adds a new student to the database.
 */
      addStudent() {
        // Create an axios instance with the necessary headers
        const axiosInstance = axios.create({
          headers: {
            'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
            'Content-Type': 'application/json',
          },
        });

        // Make a POST request to add the student to the database
        axiosInstance.post('http://127.0.0.1:8000/api/students', this.student)
          .then((response) => {
            // After successfully adding the student, update the list of all students
            this.getAllStudents();

            // Reset the student object to clear the form fields
            this.student = {};

            // Set the success message to display to the user
            this.successMsg = response.data.message;
          }).catch((error) => {
            // If an error occurs, set the error message to display to the user
            this.errorMsg = error.response.data.message;
          });
      },

      /**
       * Edit a student by ID.
       * 
       * @param {string} student_id - The ID of the student to edit.
       */
      editStudent(student_id) {
        // Log the student ID
        console.log(student_id);

        // Create an instance of axios with the required headers
        const axiosInstance = axios.create({
          headers: {
            'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
            'Content-Type': 'application/json', 
          },
        });

        // Make a GET request to retrieve the student details
        axiosInstance.get(`http://127.0.0.1:8000/api/students/${student_id}`)
          .then((response) => {
            // Update the student object with the retrieved data
            this.student = response.data.student;

            // Format the student ID and date of birth
            this.student.student_id = this.student.student_id.toString().padStart(8, '0');
            this.student.date_of_birth = new Date(this.student.date_of_birth).toISOString().split('T')[0];

            // Set the create flag to false
            this.student.create = false;
          }).catch((error) => {
              // Handle any error that occurred during the request
              this.errorMsg = error.response.data.message;
          })
      },
      /**
       * Deletes a student with the given student_id.
       * 
       * @param {number} student_id - The ID of the student to delete.
       */
      deleteStudent(student_id) {
        // Create an axios instance with the necessary headers
        const axiosInstance = axios.create({
          headers: {
            'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
            'Content-Type': 'application/json', 
          },
        });

        // Send a DELETE request to the API
        axiosInstance.delete(`http://127.0.0.1:8000/api/students/${student_id}`)
          .then((response) => {
            // Update the students data with the response data
            this.students = response.data.students;
            // Set the success message
            this.successMsg = response.data.message;
          })
          .catch((error) => {
            // Set the error message from the error response
            this.errorMsg = error.response.data.message;
          });
      },

      /**
       * Modifies a student.
       */
      modifyStudent() {
        // Check if the student is being created or updated
        if (!this.student.create) {
          // Call the updateStudent function with the student_id
          this.updateStudent(this.student.student_id);
        } else {
          // Call the addStudent function
          this.addStudent();
        }
      },

      /**
       * Navigate to the student view page
       * @param {string} student_id - The ID of the student
       */
      viewStudent(student_id) {
        // Redirect to the student view page
        this.$router.push(`/student/${student_id}`);
      },

    /**
     * Update a student by their ID.
     * 
     * @param {number} student_id - The ID of the student to update.
     */
    updateStudent(student_id) {
      // Create a new axios instance with the required headers.
      const axiosInstance = axios.create({
        headers: {
          'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
          'Content-Type': 'application/json', // You can adjust this based on your API requirements
        },
      });

      // Log the student object before making the API call.
      console.log('updateStudent', this.student);

      // Make a PUT request to update the student.
      axiosInstance.put(`http://127.0.0.1:8000/api/students/${student_id}`, this.student)
        .then((response) => {
          // Reset the student object.
          this.student = {};

          // Refresh the list of all students.
          this.getAllStudents();

          // Set the success message.
          this.successMsg = response.data.message;
        }).catch((error) => {
          // Set the error message.
          this.errorMsg = error.response.data.message;
        })
    }
    },

    /**
     * Lifecycle hook that is called when the component is mounted.
     * Calls the getAllStudents method to fetch all students.
     */
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
  