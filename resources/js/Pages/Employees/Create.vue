<template>
  <au-layout>
    <template #header>
      <au-heading>Add New Employee</au-heading>
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
        <jet-label for="department_id" value="Department"></jet-label>
        <au-select
          id="department_id"
          class="mt-1 block w-1/2"
          v-model="form.department_id"
          :error="form.errors.department_id"
          :options="departments"
        ></au-select>
        <jet-input-error :message="form.errors.department_id"></jet-input-error>
      </div>

      <!-- submit -->
      <div class="flex items-center justify-end mt-4">
        <au-reset-button @click="resetForm">Reset</au-reset-button>
        <jet-button :loading="form.processing">Create</jet-button>
      </div>
    </form>
  </au-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import AuHeading from "@/Components/Heading";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import AuResetButton from "@/Components/ResetButton.vue";
import AuSelect from "@/Components/Select.vue";

export default {
  components: {
    AppLayout,
    AuHeading,
    JetLabel,
    JetInput,
    JetInputError,
    AuResetButton,
    JetButton,
    AuSelect,
  },
  setup() {
    const form = useForm({
      name: null,
      email: null,
      department_id: null,
    });

    return { form };
  },
  props: {
    departments: Object,
  },
  methods: {
    submit() {
      this.form.post(route("employees.store"), {
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