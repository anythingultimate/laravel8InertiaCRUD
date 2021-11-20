<template>
  <app-layout>
    <template #header>
      <au-heading>Edit Department - {{ form.name }}</au-heading>
    </template>

    <div v-show="form.hasErrors">
      <div class="text-red-600 font-medium">
        Please make the following corrections:
      </div>
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
      <div class="mt-4">
        <jet-label for="phone" value="Phone"></jet-label>
        <jet-input
          type="text"
          id="phone"
          class="mt-1 block w-1/2"
          v-model="form.phone"
          :error="form.errors.phone"
        ></jet-input>
        <jet-input-error :message="form.errors.phone"></jet-input-error>
      </div>

      <!-- submit -->
      <div class="flex items-center justify-end mt-4">
        <au-reset-button @click="resetForm">Reset</au-reset-button>
        <jet-button :loading="form.processing">Update</jet-button>
      </div>
    </form>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetLabel from "@/Jetstream/Label";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetButton from "@/Jetstream/Button";
import { useForm } from "@inertiajs/inertia-vue3";
import AuHeading from "@/Components/Heading";
import AuResetButton from "@/Components/ResetButton";
import AuAnchorLink from "@/Components/AnchorLink";

export default {
  components: {
    AppLayout,
    JetLabel,
    JetInput,
    JetButton,
    JetInputError,
    AuHeading,
    AuResetButton,
    AuAnchorLink,
  },
  setup(props) {
    const form = useForm({
      name: props.department.name,
      email: props.department.email,
      phone: props.department.phone,
    });

    return { form };
  },
  props: {
    department: Object,
  },
  methods: {
    submit() {
      this.form.put(route("departments.update", this.department.id), {
        preserveScroll: (page) => Object.keys(page.props.errors).length,
      });
    },
    resetForm() {
      this.form.clearErrors();
      this.form.reset();
    },
  },
};
</script>