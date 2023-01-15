
<template>
  <body id="page-top">
    <div id="wrapper">
      <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
          <navBar />
          <formValues />
        </div>
        <footer class="bg-white sticky-footer">
          <div class="container my-auto">
            <div class="text-center my-auto copyright">
              <span>Copyright © Brand 2023</span>
            </div>
          </div>
        </footer>
      </div>
      <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
  </body>
</template>

<script>
import navBar from "./components/user/nav-bar.vue";
import formValues from "./components/user/form-values.vue";

export default {
  components: {
    navBar, 
    formValues
  },
}
</script>


<style>

</style>
