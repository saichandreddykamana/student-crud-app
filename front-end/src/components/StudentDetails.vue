<template>
  <div class="container">
      <div class="row justify-content-center ">
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
  <div class="row justify-content-center">
  <div class="col-md-9">
  <div class="card">
  <div class="card-header">
     <h5 class="card-title">Student Record</h5>
  </div>
  <div class="card-body">
  <div class="row mb-3">
     <label for="studentId" class="col-md-3 col-form-label">Student ID</label>
     <div class="col-md-9">
        <input type="text" class="form-control" id="studentId" v-model="student.student_id" disabled>
     </div>
  </div>
  <div class="row mb-3">
     <label for="surname" class="col-md-3 col-form-label">Surname</label>
     <div class="col-md-9">
        <input type="text" class="form-control" id="surname" v-model="student.surname" required>
     </div>
  </div>
  <div class="row mb-3">
     <label for="title" class="col-md-3 col-form-label">Title</label>
     <div class="col-md-9">
        <input type="text" class="form-control" id="title" v-model="student.title" required>
     </div>
  </div>
  <div class="row mb-3">
     <label for="forename1" class="col-md-3 col-form-label">Forename 1</label>
     <div class="col-md-9">
        <input type="text" class="form-control" id="forename1" v-model="student.forename_1" required>
     </div>
  </div>
  <div class="row mb-3">
     <label for="forename2" class="col-md-3 col-form-label">Forename 2</label>
     <div class="col-md-9">
        <input type="text" class="form-control" id="forename2" v-model="student.forename_2">
     </div>
  </div>
  <div class="row mb-3">
     <label for="email" class="col-md-3 col-form-label">Email</label>
     <div class="col-md-9">
        <input type="email" class="form-control" id="email" v-model="student.email" required>
     </div>
  </div>
  <div class="row mb-3">
     <label for="username" class="col-md-3 col-form-label">Username</label>
     <div class="col-md-9">
        <input type="text" class="form-control" id="username" v-model="student.username" required>
     </div>
  </div>
  <div class="row mb-3">
     <label for="gender" class="col-md-3 col-form-label">Gender</label>
     <div class="col-md-9">
        <select class="form-select" id="gender" v-model="student.gender">
           <option value="Male">Male</option>
           <option value="Female">Female</option>
           <option value="Other">Other</option>
        </select>
     </div>
  </div>
  <div class="row mb-3">
  <label for="dateOfBirth" class="col-md-3 col-form-label">Date of Birth</label>
  <div class="col-md-9">
     <input type="date" class="form-control" id="dateOfBirth" v-model="student.date_of_birth" required>
  </div>
 </div>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-primary btn-sm m-2" @click="updateStudent">Update</button>
            <button type="button" class="btn btn-danger btn-sm m-2" @click="deleteStudent">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
/**
 * Initializes the data for the component.
 *
 * @return {Object} - The initial data object.
 */
data() {
  // Initialize the student object with empty values for its properties
  const student = {
    student_id: '',
    surname: '',
    title: '',
    forename_1: '',
    forename_2: '',
    email: '',
    username: '',
    gender: '',
    date_of_birth: ''
  };

  // Initialize the errorMsg and successMsg variables to null
  const errorMsg = null;
  const successMsg = null;

  // Return the initial data object
  return { student, errorMsg, successMsg };
},
  methods: {
      /**
       * Update the student information using the API.
       *
       * @return {void} No return value.
       */
      updateStudent() {
        // Create an axios instance with custom headers
        const axiosInstance = axios.create({
          headers: {
            'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
            'Content-Type': 'application/json', // You can adjust this based on your API requirements
          },
        });

        // Make a PUT request to update the student information
        axiosInstance.put(`http://127.0.0.1:8000/api/students/${this.student.student_id}`, this.student)
          .then((response) => {
            // Update the student object with the response data
            this.student = response.data.student;
            // Pad the student ID to 8 digits
            this.student.student_id = this.student.student_id.toString().padStart(8, '0');
            // Format the date of birth to ISO string
            this.student.date_of_birth = new Date(this.student.date_of_birth).toISOString().split('T')[0];
            // Set the success message
            this.successMsg = response.data.message;
          }).catch((error) => {
            // Set the error message
            this.errorMsg = error.response.data.message;
          })
      },
    /**
     * Deletes a student from the API.
     *
     * @param {type} paramName - description of parameter
     * @return {type} description of return value
     */
    deleteStudent() {
      // Create an instance of axios with custom headers
      const axiosInstance = axios.create({
        headers: {
          'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
          'Content-Type': 'application/json', 
        },
      });

      // Send a DELETE request to the API endpoint
      axiosInstance.delete(`http://127.0.0.1:8000/api/students/${this.student.student_id}`)
        .then((response) => {
          // Check if the request was successful
          if(response.status === 200){
            // Set the success message and navigate to the dashboard
            this.successMsg = response.data.message;
            this.$router.push('/dashboard');
          }
        }).catch((error) => {
          // Set the error message if an error occurred
          this.errorMsg = error.response.data.message;
        })
    }
  },

    /**
     * Mounts the component.
     *
     * @return {void}
     */
    mounted() {
      const studentId = this.$route.params.id;

      // Create a new instance of axios with custom headers
      const axiosInstance = axios.create({
        headers: {
          'Authorization': `Bearer ${this.$store.state.userAccessToken}`,
          'Content-Type': 'application/json', 
        },
      });

      // Make GET request to retrieve student data
      axiosInstance.get(`http://127.0.0.1:8000/api/students/${studentId}`)
        .then((response) => {
          console.log(response.data);

          // Update component data with student information
          this.student = response.data.student;
          this.student.student_id = this.student.student_id.toString().padStart(8, '0');
          this.student.date_of_birth = new Date(this.student.date_of_birth).toISOString().split('T')[0];
        });
    }
};
</script>

<style scoped>
.card {
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.card-header {
  background-color: #f8f9fa;
  padding: 20px;
}

.card-title {
  font-size: 1.8rem;
  font-weight: 600;
}

.card-body {
  padding: 20px;
}

.row mb-3 {
  margin-bottom: 15px;
}

.col-md-3 {
  text-align: right;
  font-weight: 600;
}

.form-control {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

select.form-select {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
}

.card-footer {
  padding: 20px;
  text-align: right;
}

.btn {
  padding: 10px 20px;
  border-radius: 5px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
}

.btn-danger {
  background-color: #dc3545;
}
</style>
