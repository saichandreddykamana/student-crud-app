<template>
   <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-8">
          <div class="card registration-form">
            <div class="card-header">Register</div>
            <div class="card-body">
               <form @submit.prevent="register">
                  <div class="mb-3">
                     <label for="name" class="form-label">Full Name</label>
                     <input type="text" class="form-control" id="name" v-model="user.name" required>
                  </div>
                  <div class="mb-3">
                     <label for="email" class="form-label">Email address</label>
                     <input type="email" class="form-control" id="email" v-model="user.email" required>
                  </div>
                  <div class="mb-3">
                     <label for="password" class="form-label">Password</label>
                     <input type="password" class="form-control" id="password" v-model="user.password" required>
                  </div>
                  <div class="mb-3">
                     <label for="confirmPassword" class="form-label">Confirm Password</label>
                     <input type="password" class="form-control" id="confirmPassword" v-model="confirmPassword" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Register</button>
             </form>
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
       * @return {Object} The initial data object.
       */
      data() {
         return {
            // Initialize the user object with name, email, and password properties
            user: {
                  name: '',
                  email: '',
                  password: ''
            },
            // Initialize the confirmPassword property
            confirmPassword: ''
         }
      },
    methods: {
      /**
       * Registers the user by sending a POST request to the server with user data.
       * If the password matches the confirm password, it handles the response and performs the necessary actions.
       *
       * @return {void} This function does not return any value.
       */
      register() {
         if (this.user.password === this.confirmPassword) {
            axios.post('http://127.0.0.1:8000/api/register', this.user)
                  .then((response) => {
                     console.log(response);
                     this.$store.dispatch('setUserAuthenticated', true);
                     this.$store.dispatch('setUserAccessToken', response.data.token);

                     // Redirect to the dashboard once the user is logged in
                     this.$router.push('/dashboard', { replace: true });
                  });
         }
      }
    }
    }
</script>