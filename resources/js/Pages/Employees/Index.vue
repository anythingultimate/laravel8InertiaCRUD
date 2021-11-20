<template>
  <app-layout>
    <template #header>
      <au-heading>Employees</au-heading>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between mb-6">
              <au-select
                id="department_id"
                class="mt-1 block w-1/3"
                v-model="department_id"
                :options="departments"
                @change="getEmployees(department_id)"
              >
              </au-select>

              <au-anchor-link :href="route('employees.create')" v-if="$page.props.can.create"
                >New Employee
              </au-anchor-link>
            </div>
            <au-table>
              <template #header>
                <au-table-column>ID</au-table-column>
                <au-table-column>Name</au-table-column>
                <au-table-column>Department</au-table-column>
                <au-table-column>Email</au-table-column>
                <au-table-column>Actions</au-table-column>
              </template>
              <tr v-for="e in employees" :key="e.id" class="hover:bg-gray-200">
                <au-table-column>{{ e.id }}</au-table-column>
                <au-table-column>{{ e.name }}</au-table-column>
                <au-table-column>{{ e.department }}</au-table-column>
                <au-table-column>{{ e.email }}</au-table-column>
                <au-table-column>
                  <au-anchor-link
                    mode="edit"
                    v-if="e.can.edit"
                    :href="route('employees.edit', e.id)"
                    >Edit</au-anchor-link
                  >
                  <au-anchor-link mode="delete" @click="destroy(e.id)" v-if="e.can.delete"
                    >Delete</au-anchor-link
                  >
                </au-table-column>
              </tr>
            </au-table>
            <au-pagination :links="employees.links" />
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import AuHeading from "@/Components/Heading";
import AuAnchorLink from "@/Components/AnchorLink";
import AuTable from "@/Components/Table.vue";
import AuTableColumn from "@/Components/TableColumn.vue";
import AuPagination from "@/Components/Pagination";
import AuSelect from "@/Components/Select.vue";

export default {
  components: {
    AppLayout,
    AuHeading,
    AuAnchorLink,
    AuTable,
    AuTableColumn,
    AuPagination,
    AuSelect,
  },

  props: {
    employees: Object,
    departments: Object,
    department_id: [String, Number],
  },
  methods: {
    destroy(id) {
      this.$inertia.delete(route("employees.destroy", id), {preserveState: false}, {preserveScroll: true});
    },
    getEmployees(department_id) {
      this.$inertia.get(
        route("employees.index"),
        { department_id: department_id },
        { only: ["employees", "department_id"] }
      );
    },
  },
};
</script>