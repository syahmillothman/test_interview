
<template>
  <v-fragment name="users">
    <navigation-menu v-if="user != null" :role="user.role_id"></navigation-menu>

    <div v-if="showEditModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Create new user</h5>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true" @click="closeEditModal()"
                      >&times;</span
                    >
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group col-12 row">
                    <label for="body">Body</label>
                    <input
                      type="text"
                      id="body"
                      class="form-control"
                      placeholder="user@example.com"
                      v-model="userForm.body"
                      required
                    />
                  </div>

                  <div class="form-group col-12 row">
                    <label for="body">Progress</label>
                    <input
                      type="text"
                      id="body"
                      class="form-control"
                      placeholder="complete = 1, progress = 0"
                      v-model="userForm.is_complete"
                      required
                    />
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="closeEditModal()"
                  >
                    Close
                  </button>
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="updateUser()"
                  >
                    Save changes
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>

    <div v-if="showModal">
      <transition name="addusermodal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Create todo</h5>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true" @click="closeModal()"
                      >&times;</span
                    >
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group col-12 row">
                    <label for="email">Body</label>
                    <input
                      type="text"
                      id="body"
                      class="form-control"
                      placeholder="Body"
                      v-model="userForm.body"
                      required
                    />
                  </div>
                  <div class="form-group col-12 row">
                    <label for="name">Is Complete</label>
                    <input
                      type="text"
                      id="is_complete"
                      class="form-control"
                      v-model="userForm.is_complete"
                      placeholder="Complete."
                      required
                    />
                  </div>

                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="closeModal()"
                  >
                    Close
                  </button>
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="adduser()"
                  >
                    Save changes
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>

    <div id="container col-8" style="margin-top: 3em">
      <notifications group="success" />
      <notifications group="error" />

      <div id="content" class="col-8 offset-md-2">
        <div class="card card-default">
          <div class="card-header"><span>Manage Todo</span></div>
          <div class="card-body">
            <div
              class=""
              style="margin-top: 1em; margin-bottom: 1em"
              @click="showModal = true"
            >
              <button class="btn btn-primary">Create todo</button>
            </div>
            <div class="table-responsive">
              <table
                class="table table-condensed table-bordered table-hover responsive"
              >
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Body</th>
                    <th>Is Complete</th>
                    <th>User</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="todos.length == 0">
                    <td colspan="10" class="text-center">No data available</td>
                  </tr>
                  <tr v-for="(todo, index) in todos">
                    <td>{{ index + 1 }}</td>
                    <td>{{ todo.body }}</td>
                    <td>{{ todo.is_complete }}</td>
                    <td>{{ todo.user.name }}</td>
                    <td>
                      <div class="btn-group">
                        <button
                          type="button"
                          class="btn btn-primary dropdown-toggle"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          Action
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" @click="editUser(index)"
                            >Edit</a
                          >
                          <a class="dropdown-item" @click="removeUser(index)"
                            >Delete</a
                          >
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
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
import axios from "axios";

export default {
  mixins: [appMixins],
  mounted() {
    this.getUser()
      .then((response) => {
        this.user = response.data.data;
      })
      .catch((error) => console.log(error.toString()));

    this.userForm.role = this.roles[1];

    axios
      .get("v1/admin/todos", {
        headers: { Authorization: `Bearer ${this.getAuthToken()}` },
      })
      .then((response) => (this.todos = response.data.data))
      .catch((error) => {
        console.log("display error here");
      });
  },
  data() {
    return {
      showModal: false,
      showEditModal: false,
      passwordNotMatch: false,
      loading: false,
      user: null,
      todos: [],
      roles: [
        { id: 1, name: "administrator" },
        { id: 2, name: "user" },
      ],
      userForm: {
        users_id: 5,
        body: null,
        is_complete: null,
      },
    };
  },
  methods: {
    closeEditModal() {
      this.showEditModal = false;
      this.resetForm();
    },
    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    adduser() {
        axios
          .post("v1/admin/todos", this.userForm, {
            headers: {
              Authorization: `Bearer ${this.getAuthToken()}`,
            },
          })
          .then((response) => {
            this.todo = [...this.todos, response.data.data];
            window.location.reload();

            this.closeModal();

            this.$notify({
              group: "success",
              type: "success",
              title: "Success",
              text: "New user added.",
            });
          })
          .catch((error) => {
            this.$notify({
              group: "error",
              type: "error",
              title: "Error",
              text: error.toString(),
            });
          });
    },
    resetForm() {
      this.userForm = {
        email: null,
        name: null,
        role: this.roles[1],
        password: null,
        password_confirmation: null,
      };
    },
    removeUser(index) {
      const todo = this.todos[index];

      axios
        .delete("v1/admin/todos/" + todo.id, {
          headers: { Authorization: `Bearer ${this.getAuthToken()}` },
        })
        .then((response) => {
          console.log(response.data);
          this.todos.splice(index, 1);
        })
        .catch((error) => {
          console.log(error.toString());
        });
    },
    editUser(index) {
      this.userForm = this.todos[index];
      this.showEditModal = true;
    },
    updateUser() {
      axios
        .put("v1/admin/todos/" + this.userForm.id, this.userForm, {
          headers: { Authorization: `Bearer ${this.getAuthToken()}` },
        })
        .then((response) => {
          this.closeEditModal();

          this.$notify({
            group: "success",
            type: "success",
            title: "Success",
            text: "User details saved and changed.",
          });
        })
        .catch((error) => {});
    },
  },
  components: {
    "navigation-menu": Menu,
  },
};
</script>