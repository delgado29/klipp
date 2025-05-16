<template>
  <b-navbar fixed="top" variant="dark" expand="lg" class="bg-transparent">
    <b-container fluid>
      <b-navbar-toggle target="nav-collapse" />
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav class="ms-auto" align="end">
          <slot name="auth-buttons">
            <router-link to="/login" class="btn btn-outline-light btn-sm ms-3">
              Log In / Sign Up
            </router-link>
          </slot>
          <b-button variant="light" class="ms-3">List your business</b-button>
        </b-navbar-nav>
      </b-collapse>
    </b-container>
  </b-navbar>
</template>

<style scoped>
.bg-transparent {
  background-color: rgba(0, 0, 0, 0.5) !important;
}
</style>