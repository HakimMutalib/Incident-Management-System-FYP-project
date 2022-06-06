<template>
  <div class="container">
    <div class="row justify-content-center my-5">
      <div class="col-sm-12 col-md-8 col-lg-5 my-4">
        <div class="rounded mx-auto d-block">
          <slot name="logo" />
        </div>

        <div style="background-color:black" class="rounded-3">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
