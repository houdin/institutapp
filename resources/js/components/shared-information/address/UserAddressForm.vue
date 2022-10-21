<template>
  <ValidationObserver ref="form" v-slot="{ invalid, validated, handleSubmit }">
    <form class="address-form" @submit.prevent="handleSubmit(beforeSubmit)">
      <div class="row">
        <div class="col-sm-12">
          <ValidationProvider name="Street Address" vid="street_address" :rules="{ required: true, regex: /^[A-Za-z0-9.\s\\/-]+$/ }" v-slot="{ errors, invalid, changed }">
            <div :class="{
                'form-group': true,
                'has-error': changed ? invalid : false,
              }">
              <label for="street_address" class="control-label">Address:
              </label>
              <input class="form-control" id="street_address" type="text" name="street_address" v-model="address.street_address" />
              <span class="help-block" v-show="errors[0]">
                <strong>{{ errors[0] }}</strong>
              </span>
            </div>
            <!-- /.form-group -->
          </ValidationProvider>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <ValidationProvider name="State" vid="state" rules="required" v-slot="{ errors, invalid, changed }">
          <div class="col-sm-6" v-if="states">
            <div :class="{
                'form-group': true,
                'has-error': changed ? invalid : false,
              }">
              <label for="state" class="control-label">State:</label>
              <select name="state" id="state" class="form-control" v-model="address.state">
                <option></option>
                <option v-for="(state, id) in states" :value="id" :key="id">
                  {{ state }}
                </option>
              </select>
              <span class="help-block" v-show="errors[0]">
                <strong>{{ errors[0] }}</strong>
              </span>
            </div>
            <!-- /.form-group -->
          </div>
        </ValidationProvider>
        <!-- /.col -->
        <div class="col-sm-6">
          <ValidationProvider name="City" vid="city" rules="required|alpha_spaces" v-slot="{ errors, invalid, changed }">
            <div :class="{
                'form-group': true,
                'has-error': changed ? invalid : false,
              }">
              <label for="city" class="control-label">City: </label>
              <input type="text" name="city" id="city" class="form-control" v-model="address.city" />
              <span class="help-block" v-show="errors[0]">
                <strong>{{ errors[0] }}</strong>
              </span>
            </div>
            <!-- /.form-group -->
          </ValidationProvider>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-sm-6">
          <ValidationProvider name="Postal Code" vid="postal_code" rules="required|between:1000,99999" v-slot="{ errors, invalid, changed }">
            <div :class="{
                'form-group': true,
                'has-error': changed ? invalid : false,
              }">
              <label for="postal_code" class="control-label">Postal Code:
              </label>
              <input class="form-control" id="postal_code" name="postal_code" type="text" v-model="address.postal_code" />
              <span class="help-block" v-show="errors[0]">
                <strong>{{ errors[0] }}</strong>
              </span>
            </div>
            <!-- /.form-group -->
          </ValidationProvider>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-sm-12">
          <button class="btn btn-danger pull-right" type="button" @click="close">
            Cancel
          </button>
          <button class="btn btn-primary pull-left" type="submit">
            Submit
          </button>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </form>
  </ValidationObserver>
</template>

<script>
export default {
  props: ["editAddress", "close"],

  data() {
    return {
      states: null,
      address: {
        street_address: "",
        state: "",
        city: "",
        postal_code: "",
      },
    };
  },

  mounted() {
    this.setStates();
    if (this.editAddress) {
      this.setAddress();
    }
  },

  methods: {
    /**
     * performs an ajax request for the states
     * @return {void}
     */
    setStates() {
      axios
        .get(this.$laravel.urls.shopping_user_states)
        .then((response) => {
          this.states = response.data.states;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    /**
     * sets the address when the user is editing an address
     * it will bind the values to the form fields
     * @return {void}
     */
    setAddress() {
      this.address = {
        street_address: this.editAddress.street_address,
        postal_code: this.editAddress.postal_code,
        state: this.editAddress.state_id,
        city: this.editAddress.city,
      };
    },

    /**
     * prevents the form from being submitted unless it passes validation
     * @return {boolean}
     */
    beforeSubmit() {
      this.$refs.form.validate().then((success) => {
        if (success) {
          if (this.editAddress) {
            this.edit();
          } else {
            this.ajaxRequest(window.Laravel.urls.address_url);
          }
        }
      });
    },

    /**
     * on edit it will add patch and change url
     * @return {boolean}
     */
    edit() {
      this.address._method = "patch";
      this.ajaxRequest(
        window.Laravel.urls.address_url + "/" + this.editAddress.id
      );
    },

    /**
     * performs an ajax request to add or edit an address
     * @return {boolean}
     */
    ajaxRequest(url) {
      axios
        .post(url, this.address)
        .then((response) => this.updateMessage(response.data))
        .catch((error) => console.log(error));
    },

    /**
     * Displays a user message
     * @param data
     * @return void
     */
    updateMessage(data) {
      Event.$emit("update-user-message", data.message);
      this.$emit("form-submit");
    },

    /**
     * Displays a user error
     * @return void
     */
    updateError() {
      Event.$emit("update-user-message", data.message);
      this.close();
    },
  },
};
</script>


