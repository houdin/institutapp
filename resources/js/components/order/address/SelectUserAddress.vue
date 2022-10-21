<template>
  <div>
    <h4>Where do you want the package shipped</h4>
    <add-new-address :refresh="refreshAddress"> </add-new-address>
    <ValidationObserver ref="form" v-slot="{ handleSubmit, invalid, validated }">
      <form @submit.prevent="handleSubmit(onSubmit)">
        <ValidationProvider name="Address" rules="required" v-slot="{ errors, invalid, changed }">
          <div :class="{
              'form-group': true,
              'has-error': changed ? invalid : false,
            }">
            <div class="row" v-for="(row, rowKey) in addresses" :key="rowKey">
              <div class="col-sm-6" v-for="(address, colKey) in row" :key="colKey">
                <div :class="{ 'address-box': true, active: isActive(address.id) }">
                  <label :for="address.id" class="address-details">
                    <p>{{ address.street_address }}</p>
                    <p>
                      {{ address.city }}, {{ address.state }},
                      {{ address.postal_code }}
                    </p>
                    <input class="address-radio-button" type="radio" :id="address.id" name="address" :value="address.id" v-model="pickedAddress" />
                  </label>
                  <span class="text-danger">{{ errors[0] }}</span>
                  <div class="address-box-footer">
                    <div class="address-edit-button">
                      <edit-address :address="address" :refresh="refreshAddress">
                      </edit-address>
                    </div>
                    <!-- /.address-edit -->
                    <div class="address-delete-button">
                      <delete-address :address="address" :refresh="refreshAddress">
                      </delete-address>
                    </div>
                    <!-- /.address-edit -->
                  </div>
                  <!-- /.address-footer-box -->
                </div>
                <!-- /.address-box -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.form-group -->
          <div class="row">
            <div class="col-sm-2 col-sm-offset-5">
              <input class="btn btn-primary" type="submit" />
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </ValidationProvider>
      </form>
    </ValidationObserver>
  </div>
</template>

<script>
export default {
  props: ["addresses", "order_id", "refreshAddress"],

  data() {
    return {
      pickedAddress: "",
    };
  },

  methods: {
    /**
     * should active class be applied
     * This is used in the template for address-boxes div
     * @param id
     * @return {boolean}
     */
    isActive(id) {
      return id === this.pickedAddress;
    },

    /**
     * selects the current address
     * @return {void}
     */
    onSubmit() {
      let post = { address_id: this.pickedAddress };

      this.$refs.form.validate().then((success) => {
        if (!this.order_id) {
          this.ajaxRequest(this.$laravel.urls.shopping_order_add_api, post);
        } else {
          this.edit(post);
        }
      });
    },

    /**
     * changes ajax request for an update
     * @return void
     */
    edit(post) {
      post._method = "PATCH";
      let url = this.$laravel.urls.shopping_order_add_api + "/" + this.order_id;
      this.ajaxRequest(url, post);
    },

    /**
     * does an ajax request to the OrderController
     * @return void
     */
    ajaxRequest(url, post) {
      axios
        .post(url, post)
        .then((response) => {
          this.updateMessage(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    /**
     * updates the users message
     * @return void
     */
    updateMessage(data) {
      Event.$emit("update-user-message", data.message);
      Event.$emit("user-pick-address", data);
    },

    /**
     * updates the users message
     * @return void
     */
    updateError() {
      Event.$emit("update-user-error", "There was an error, please try again");
    },
  },
};
</script>
