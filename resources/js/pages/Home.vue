<template>
  <div class="container">
    <div class="card card-default" style="margin-top: 3em">
      <div class="card-header">This is home page for interview test.</div>
      <div class="card-body">
        <p>Click below button to login to dashboard.</p>
        <ul>
          <li>
            1. Below button will navigate user to page login if user is
            currently logged in state then we redirect current user to dashboard
            page.
          </li>
        </ul>
        <router-link :to="{ name: 'login' }" class="btn btn-primary"
          >Go to app</router-link
        >
      </div>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    //
  },
};
</script>