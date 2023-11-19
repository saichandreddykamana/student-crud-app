<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">My App</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item" v-if="!isUserAuthenticated">
            <router-link class="nav-link" to="/">Home</router-link>
          </li>
          <li class="nav-item" v-if="!isUserAuthenticated">
            <router-link class="nav-link" to="/login">Login</router-link>
          </li>
          <li class="nav-item" v-if="!isUserAuthenticated">
            <router-link class="nav-link" to="/register">Register</router-link>
          </li>
          <li class="nav-item" v-if="isUserAuthenticated">
            <router-link class="nav-link" to="/dashboard">Dashboard</router-link>
          </li>
        </ul>
        <div class="form-inline my-2 my-lg-0" v-if="isUserAuthenticated">
          <button @click="logout" class="btn btn-primary"><span class="glyphicon glyphicon-log-out"></span> Logout</button>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
import axios from 'axios';


  export default {
    name: 'NavBar',

    /**
     * Initializes the data object with empty email and password properties.
     *
     * @return {Object} The data object with email and password properties.
     */
    data() {
      return {
        email: '',
        password: ''
      };
    },

    computed: {
      /**
       * Check if the user is authenticated.
       *
       * @return {Boolean} Whether the user is authenticated or not.
       */
      isUserAuthenticated() {
        return this.$store.state.isUserAuthenticated;
      },
    },

    methods: {
    /**
     * Logout the user and remove their authentication information.
     *
     * @return {void} No return value.
     */
    logout() {
      // Send a GET request to the logout API endpoint
      axios.get('http://127.0.0.1:8000/api/logout')
        .then((response) => {
          // Check if the response code is 200
          if(response.data.code === 200) {
            // Remove the 'isAuthenticated' value from local storage
            localStorage.removeItem('isAuthenticated');
            // Dispatch an action to update the user's authenticated status in the store
            this.$store.dispatch('setUserAuthenticated', false);
            // Dispatch an action to set the user's access token to null in the store
            this.$store.dispatch('setUserAccessToken', null);
            // Redirect the user to the login page
            this.$router.push('/login');
          }
        });
    }
        },
      };
  </script>
  
  <style scoped>
  .navbar {
    margin-bottom: 30px;
  }
  </style>
  