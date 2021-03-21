
import axios from 'axios';

export default {
  created: function () {
    this.hello();
  },
  methods: {
    hello: function () {
      console.log('hello from mixin!');
    },
    isLoggedIn: function () {
      return this.getAuthToken() != null ? true : false;
    },
    getUser: function () {
      return axios.get('/v1/me', { headers: { 'Authorization': `Bearer ${this.getAuthToken()}` } });
    },
    getTodo: function () {
      return axios.get('/v1/me', { headers: { 'Authorization': `Bearer ${this.getAuthToken()}` } });
    },
    getAuthToken: function () {
      return localStorage.getItem('token');
    }
  }
};