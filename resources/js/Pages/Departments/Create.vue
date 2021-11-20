<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create New Department
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
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
                <jet-button :loading="form.processing">Create</jet-button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import JetLabel from "@/Jetstream/Label.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";
import AuResetButton from "@/Components/ResetButton.vue";

export default {
  components: {
    AppLayout,
    JetLabel,
    JetInput,
    JetInputError,
    JetButton,
    AuResetButton,
  },
  setup() {
    const form = useForm({
      name: null,
      email: null,
      phone: null,
    });

    return { form };
  },
  methods: {
    submit() {
      this.form.post(route("departments.store"), {
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

<style>
</style>