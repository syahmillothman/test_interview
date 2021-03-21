
<template>
  <v-fragment :name="'dashboard'">
    <navigation-menu :role="user.role_id"></navigation-menu>
    <div id="container col-8" style="margin-top: 3em">
      <notifications group="success" />
      <notifications group="error" />
      <div id="content" class="col-8 offset-md-2">
        <div class="card card-default">
          <div class="card-header"><span>Change Profile Detail</span></div>
          <div class="card-body">
            <div class="form-group col-8 row">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                class="form-control"
                placeholder="user@example.com"
                v-model="user == null ? '' : user.email"
                required
              />
              <span class="label-text">Your account email.</span>
            </div>
            <div class="form-group col-8 row">
              <label for="name">Name</label>
              <input
                type="text"
                id="name"
                class="form-control"
                v-model="user == null ? '' : user.name"
                placeholder="account password."
                required
              />
              <span class="label-text">Your account name.</span>
            </div>

            <div class="form-group col-8 row">
              <button
                type="submit"
                class="btn btn-primary d-flex"
                :disabled="loading"
                style="margin-top: 2em"
                @click="updateProfile()"
              >
                <span
                  v-if="loading"
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span
                >&nbsp; Change Profile
              </button>
            </div>

            <div style="margin-top: 2em"></div>
            <hr />
            <div style="margin-top: 2em"></div>

            <div class="form-group col-8 row">
              <label for="email">New password</label>
              <input
                type="password"
                id="password"
                class="form-control"
                placeholder="New password"
                v-model="password"
                required
              />
              <span class="label-text">Change your account password.</span>
            </div>
            <div class="form-group col-8 row">
              <label for="password">New Password Confirmation</label>
              <input
                type="password"
                id="newpassword"
                class="form-control"
                @keyup="checkPassword()"
                v-model="newPasswordConfirmation"
                placeholder="New account password confirmation."
                required
              />
              <span class="text-danger" v-if="passwordNotMatch"
                >Password did not match.</span
              >
              <span class="label-text"
                >Repeat your new confirmation password.</span
              >
            </div>
            <div class="form-group col-8 row">
              <button
                type="submit"
                class="btn btn-danger"
                :disabled="loading"
                style="margin-top: 2em"
                @click="changePassword()"
                @keyup.enter="changePassword()"
              >
                <span
                  v-if="loading"
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span
                >&nbsp; Change Password
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </v-fragment>
</template>
<script>
import appMixins from "../services/appMixins";
import Menu from "../components/Menu";

export default {
  mixins: [appMixins],
  mounted() {
    this.getUser()
      .then((response) => {
        this.user = response.data.data;
      })
      .catch((error) => console.log(error.toString()));
  },

  methods: {
    changePassword() {
      if (
        this.password == "" ||
        this.newPasswordConfirmation == "" ||
        this.password != this.newPasswordConfirmation
      ) {
        this.passwordNotMatch = true;
        setTimeout(() => (this.passwordNotMatch = false), 2000);
      } else {
        axios
          .post(
            "v1/changepassword",
            {
              password: this.password,
            },
            { headers: { Authorization: `Bearer ${this.getAuthToken()}` } }
          )

          .then((response) => {
            this.$notify({
              group: "success",
              type: "success",
              title: "Success",
              text: response.data.message,
            });

            this.password = "";
            this.newPasswordConfirmation = "";
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              title: "Unable to proceed.",
              type: "error",
              text: error.toString(),
            });

            this.password = "";
            this.newPasswordConfirmation = "";
          });
      }
    },
    checkPassword() {
      //run debounce method here
      _.debounce(() => console.log("debounce"), 1000);
    },
    debounceInput() {
      _.debounce(function () {
        console.log("debounce");
      }, 1000);
    },
    updateProfile() {
      axios
        .put("v1/me/param", this.user, {
          headers: { Authorization: `Bearer ${this.getAuthToken()}` },
        })
        .then((response) => {
          console.log(response.data);
          this.$notify({
            group: "success",
            type: "success",
            title: "Success",
            text: response.data.message,
          });
        })
        .catch((error) => {
          this.$notify({
            group: "error",
            title: "Unable to proceed.",
            type: "error",
            text: error.toString(),
          });
        });
    },
  },
  data() {
    return {
      password: "",
      newPasswordConfirmation: "",
      loading: false,
      user: null,
      passwordNotMatch: false,
    };
  },
  components: {
    "navigation-menu": Menu,
  },
};
</script>