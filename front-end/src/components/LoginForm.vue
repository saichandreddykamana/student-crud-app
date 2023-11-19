<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
          <div class="card login-form">
            <div class="card-header">Login</div>
            <div class="card-body">
              <form @submit.prevent="onSubmit">
                <div class="mb-3">
                  <label for="emailInput" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="emailInput" v-model="email" required>
                </div>
                <div class="mb-3">
                  <label for="passwordInput" class="form-label">Password</label>
                  <input type="password" class="form-control" id="passwordInput" v-model="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { defineComponent } from 'vue';
  import axios from 'axios';
  
  export default defineComponent({
    name: 'LoginForm',
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      onSubmit() {
        const data = {
          email: this.email,
          password: this.password,
        };
  
        axios.post('http://127.0.0.1:8000/api/login', data)
          .then((response) => {
            
            
            this.$store.dispatch('setUserAuthenticated', true);
            this.$store.dispatch('setUserAccessToken', response.data.token);

            // Redirect to the dashboad once the user is logged in
            this.$router.push('/dashboard', { replace: true });
          })
          .catch((error) => {
            console.error(error);
          });
      },
    },
  });
  </script>
  
  <style scoped>

  .login-form {
    margin-top: 50px;
  }
  </style>
  