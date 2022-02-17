<template>
	<div>
		<div class="section-header">
			<h1>User</h1>
			<nuxt-link :to="{name: 'dashboard-sadmin-user-create'}" class="btn btn-primary">Create User</nuxt-link>
		</div>

		<div class="section-body">
			<div class="row bg-white rounded p-3 shadow">
				<div class="d-flex w-100 justify-content-end flex-lg-row flex-column">
					<form class="d-flex mb-3" @submit.prevent="search">
						<input class="form-control" type="text" placeholder="Search..." v-model="searchOption.keyword">
						<select class="form-control" v-model="searchOption.collum">
							<option value="name">Search by name</option>
						</select>
						<button type="submit" class="btn btn-primary">
							<i>
								<icon :icon="['fas', 'search']"></icon>
							</i>
						</button>
					</form>
				</div>
				<table class="table table-striped text-center table-responsive-xl">
					<thead>
						<tr>
							<th scope="col">Image</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Password</th>
							<th scope="col">User Type</th>
							<th scope="col">status</th>
							<th scope="col">Create At</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody class="text-center" v-if="loading">
						<td colspan="8">
							<Loader />
						</td>
					</tbody>
					<tbody class="text-center" v-else-if="users.data && users.data.length >= 1">
						<tr v-for="user in users.data" :key="user.id">
							<td>
								<img :src="`${url}${user.avatar}`" class="img-fluid p-1 max-h250" :alt="user.name">
							</td>
							<td>{{user.name}}</td>
							<td>{{user.email}}</td>
							<td>{{user.text_password}}</td>
							<td>{{user.role.name}}</td>
							<td>
								<button class="badge badge-danger" type="button" @click="changeStatus(user.id)" v-if="user.suspend">Suspended</button>
								<button class="badge badge-success color-black" type="button" @click="changeStatus(user.id)" v-else>Active</button>
							</td>
							<td>{{user.updated_at | date}}</td>
							<td>
								<nuxt-link :to="{name: 'dashboard-sadmin-user-edit-id', params:{id: user.id}}" class="btn btn-icon btn-primary mx-2 my-2">
									<i>
										<icon :icon="['fas', 'edit']"></icon>
									</i>
								</nuxt-link>
							</td>
						</tr>
					</tbody>
					<tbody v-else>
						<td colspan="8" class="pt-3">
							<Not-found message="No User found" />
						</td>
					</tbody>
				</table>
				<pagination :data="users" @pagination-change-page="getResults" class="justify-content-center mt-3 paginate"></pagination>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		name: "all-users",
		middleware: "sadmin",
		head() {
			return {
				title: `All Users - ${this.appName}`,
			};
		},
		data() {
			return {
				click: true,
				users: {},
				searchOption: {
					keyword: "",
					collum: "name",
				},
				loading: true,
			};
		},
		methods: {
			//Get User
			getAllUser() {
				this.$axios.get("all-user").then(
					(response) => {
						this.users = response.data.users;
						this.loading = false;
					},
					(error) => {
						$nuxt.$emit("error", error);
					}
				);
			},
			getResults(page = 1) {
				this.$axios.get("all-user?page=" + page).then((response) => {
					this.users = response.data.users;
				});
			},

			search() {
				if (this.click) {
					this.click = false;
					this.loading = true;
					this.$axios.post("search-user", this.searchOption).then(
						(response) => {
							this.users = response.data.users;
							this.loading = false;
							this.click = true;
						},
						(error) => {
							$nuxt.$emit("error", error);
							this.click = true;
						}
					);
				}
			},

			changeStatus(id) {
				if (this.click) {
					this.click = false;
					this.$axios.post(`status-user/${id}`).then(
						(response) => {
							$nuxt.$emit("triggerUser");
							this.click = true;
						},
						(error) => {
							$nuxt.$emit("error", error);
							this.click = true;
						}
					);
				}
			},
		},

		created() {
			this.getAllUser();
			this.$nuxt.$on("triggerUser", () => {
				this.getAllUser();
			});
		},

		beforeDestroy() {
			this.$nuxt.$off("triggerUser");
		},
	};
</script>
