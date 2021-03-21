<template>
  <div class="container col-3" style="position: relative; top: 120px">
    <div class="card card-default">
      <div class="card-body" style="min-height: 300px">
        <p>Use your email and passwod to sign in.</p>
        <div class="alert alert-danger text-center" v-if="has_error">
          <span>{{ error }}</span>
        </div>
        <form autocomplete="off" @submit.prevent="login" method="post">
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              class="form-control"
              placeholder="user@example.com"
              v-model="email"
              required
            />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              class="form-control"
              v-model="password"
              placeholder="account password."
              required
            />
          </div>
          <button
            type="submit"
            class="btn btn-primary btn-block"
            :disabled="loading"
            style="margin-top: 2em"
          >
            <span
              v-if="loading"
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true"
            ></span
            >&nbsp; Sign in
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: null,
      loading: false,
      password: null,
      has_error: false,
      error: null,
    };
  },
  mounted() {
    //
  },
  methods: {
    login() {
      //@TODO move this method to state management or auth service instead
      var app = this;
      app.loading = true;
      axios
        .post("/v1/login", { email: app.email, password: app.password })
        .then((response) => {
          if (response.data.status_code == 403) {
            app.has_error = true;
            app.loading = false;
            app.error = response.data.message;
            app.password = "";
            setTimeout(() => (app.has_error = false), 2000);
          } else if (response.data.status_code == 200) {
            const redirectTo = "dashboard";
            //const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'admin.dashboard' : 'dashboard'
            localStorage.setItem("token", response.data.data.token);
            this.$router.replace({ name: redirectTo });
            this.$emit("login");
          }
        })
        .catch((error) => {
          app.has_error = true;
          app.loading = false;
          app.error = error.toString();
        });
    },
  },
};
</script>