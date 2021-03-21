<template>
  <nav
    class="navbar navbar-expand-md navbar-dark bg-dark"
    v-if="loggedIn || show"
    @login="show = true"
  >
    <div class="container">
      <a class="navbar-brand" href="/"> </a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label=""
      >
        <span class="navbar-toggler-icon"> </span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto" v-if="role == 1">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Users
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <router-link class="dropdown-item" :to="{ name: 'manage-users' }"
                >Manage Users</router-link
              >
              <!-- <router-link class="dropdown-item" :to="{ name: 'manage-todos' }"
                >Todo List</router-link
              > -->
            </div>
          </li>
        </ul>

        <ul class="navbar-nav mr-auto" v-if="role == 2">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Todo
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <router-link class="dropdown-item" :to="{ name: 'create-todos' }"
                >Todo List</router-link
              >
            </div>
          </li>
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">{{
              user == null ? "....." : user.email
            }}</a>
          </li>
          <li class="nav-item dropdown">
            <a
              id="navbarDropdown"
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              v-pre
            >
            </a>

            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="navbarDropdown"
            >
              <router-link class="dropdown-item" :to="{ name: 'dashboard' }"
                >Profile
              </router-link>

              <a class="dropdown-item" @click="logout()">Sign out </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
import appMixins from "../services/appMixins";

export default {
  mixins: [appMixins],
  mounted() {
    this.getUser().then((response) => {
      this.user = response.data.data;
    });
    this.loggedIn = this.isLoggedIn();
  },
  created() {
    this.loggedIn = this.isLoggedIn();
    console.log("created");
  },
  data() {
    return {
      loading: false,
      user: null,
      loggedIn: null,
    };
  },
  props: ["show", "role"],
  methods: {
    logout() {
      localStorage.clear();
      this.$router.push({ name: "login" });
      this.loggedIn = false;
    },
  },
};
</script>