<template>
  <app-layout title="Departments">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Departments
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-end mb-6">
              <au-anchor-link
                :href="route('departments.create')"
                v-if="$page.props.can.create"
                >Create Department
              </au-anchor-link>
            </div>
            <Table>
              <template #header>
                <TableColumn
                  @click="sortColumn('id')"
                  :sortHeader="true"
                  field="id"
                  :sortby="sortby"
                  :sort="sort"
                  >ID</TableColumn
                >
                <TableColumn
                  @click="sortColumn('name')"
                  :sortHeader="true"
                  field="name"
                  :sortby="sortby"
                  :sort="sort"
                  >Name</TableColumn
                >
                <TableColumn
                  @click="sortColumn('email')"
                  :sortHeader="true"
                  field="email"
                  :sortby="sortby"
                  :sort="sort"
                  >Email</TableColumn
                >
                <TableColumn>Phone</TableColumn>
                <TableColumn>Actions</TableColumn>
              </template>
              <tr
                v-for="d in departments.data"
                :key="d.id"
                class="hover:bg-gray-200"
              >
                <TableColumn>{{ d.id }}</TableColumn>
                <TableColumn>{{ d.name }}</TableColumn>
                <TableColumn>{{ d.email }}</TableColumn>
                <TableColumn>{{ d.phone }}</TableColumn>
                <TableColumn>
                  <au-anchor-link
                    mode="edit"
                    v-if="d.can.edit"
                    :href="route('departments.edit', d.id)"
                    >Edit</au-anchor-link
                  >
                  <au-anchor-link
                    mode="delete"
                    @click="destroy(d.id)"
                    v-if="d.can.delete"
                    >Delete</au-anchor-link
                  >
                </TableColumn>
              </tr>
            </Table>
            <Pagination :links="departments.links" />
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TableColumn from "@/Components/TableColumn.vue";
import Table from "@/Components/Table.vue";
import Pagination from "@/Components/Pagination.vue";
import AuAnchorLink from "@/Components/AnchorLink";

export default defineComponent({
  components: {
    AppLayout,
    TableColumn,
    Table,
    Pagination,
    AuAnchorLink,
  },
  props: {
    departments: Object,
  },
  methods: {
    destroy(id) {
      this.$inertia.delete(
        route("departments.destroy", id),
        { preserveState: false },
        { preserveScroll: true }
      );
    },
    employees(id) {
      this.$inertia.visit(route("employees.index"), {
        method: "get",
        data: { department_id: id },
      });
      // this.$inertia.get(route('employees.index'), {department_id: id});
    },
    sortColumn(col) {
      var sort = this.sort;
      if (col == this.sortby) {
        if (this.sort == "asc") {
          sort = "desc";
        } else {
          sort = "asc";
        }
      }

      this.$inertia.get(route("departments.index"), {
        sortby: col,
        sort: sort,
        page: this.departments.current_page,
      });
    },
  },
});
</script>

<style></style>
