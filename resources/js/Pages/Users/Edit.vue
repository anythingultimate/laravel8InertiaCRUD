<template>
  <au-layout>
    <template #header>
      <au-heading>Edit User - {{ form.name }}</au-heading>
    </template>

    <div v-show="form.hasErrors">
      <div class="text-red-600 font-medium">
        Please make the following corrections:
      </div>
    </div>

    <div v-show="form.wasSuccessful">
      <div class="text-green-600 font-medium">Profile Updated.</div>
    </div>
    <div v-show="form.recentlySuccessful">
      <div class="text-green-600 font-medium">Profile was updated.</div>
    </div>

    <form @submit.prevent="submit">
      <div>
        <jet-label for="name" value="Name"></jet-label>
        <jet-input
          type="text"
          id="name"
          class="mt-1 block w-1/2"
          v-model="form.name"
          required
          autofocus
          :error="form.errors.name"
        ></jet-input>
        <jet-input-error :message="form.errors.name"></jet-input-error>
      </div>
      <div class="mt-4">
        <jet-label for="email" value="Email"></jet-label>
        <jet-input
          type="email"
          id="email"
          class="mt-1 block w-1/2"
          v-model="form.email"
          :error="form.errors.email"
        ></jet-input>
        <jet-input-error :message="form.errors.email"></jet-input-error>
      </div>

      <div>
        <jet-label for="image" value="Image"></jet-label>
        <input
          type="file"
          class="hidden"
          ref="photo"
          @change="updatePhotoPreview"
        />

        <div class="mt-2" v-show="!photoPreview && user.image">
          <img
            :src="currentImage()"
            class="rounded-full h-20 w-20 object-cover"
          />
        </div>

        <div class="mt-2" v-show="photoPreview">
          <span
            class="block rounded-full w-20 h-20"
            :style="
              'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
              photoPreview +
              '\');'
            "
          >
          </span>
        </div>

        <jet-input-error :message="form.errors.image"></jet-input-error>
        <jet-button
          class="mt-2 mr-2"
          type="button"
          @click.prevent="selectNewPhoto"
          >Select a New Photo</jet-button
        >
      </div>

      <!-- submit -->
      <div class="flex items-center justify-end mt-4">
        <au-reset-button @click="resetForm">Reset</au-reset-button>
        <jet-button :loading="form.processing">Update</jet-button>
      </div>
    </form>
  </au-layout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import AuHeading from "@/Components/Heading";
import AuResetButton from "@/Components/ResetButton.vue";
import AuSelect from "@/Components/Select.vue";
import AuAnchorLink from "@/Components/AnchorLink";

export default {
  components: {
    AppLayout,
    JetLabel,
    JetInput,
    JetInputError,
    JetButton,
    AuHeading,
    AuResetButton,
    AuSelect,
    AuAnchorLink,
  },
  setup(props) {
    const form = useForm({
      _method: "PUT",
      name: props.user.name,
      email: props.user.email,
      image: props.user.image,
    });

    return { form };
  },
  props: {
    user: Object,
  },
  methods: {
    submit() {
      if (this.$refs.photo) {
        this.form.image = this.$refs.photo.files[0];
      }
      this.form.post(route("update-profile"), {
        preserveScroll: (page) => Object.keys(page.props.errors).length,
      });
    },
    resetForm() {
      this.form.clearErrors();
      this.form.reset();
    },
    currentImage() {
      return "/storage/" + this.user.image;
    },
    selectNewPhoto() {
      this.$refs.photo.click();
    },
    updatePhotoPreview() {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.photoPreview = e.target.result;
      };
      reader.readAsDataURL(this.$refs.photo.files[0]);
    },
  },
};
</script>