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

    data() {
      return {
        email: '',
        password: ''
      };
    },

    computed: {
      isUserAuthenticated() {
        return this.$store.state.isUserAuthenticated;
      },
    },

    methods: {
      logout() {
        axios.get('http://127.0.0.1:8000/api/logout')
          .then((response) => {
            if(response.data.code === 200) {
              localStorage.removeItem('isAuthenticated');
              this.$store.dispatch('setUserAuthenticated', false);
              this.$store.dispatch('setUserAccessToken', null);
              this.$router.push('/login');
            }
          });
      },
    },
  };
  </script>
  
  <style scoped>
  .navbar {
    margin-bottom: 30px;
  }
  </style>
  