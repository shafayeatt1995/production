<template>
	<div>
		<div class="section-header">
			<h1>Style</h1>
			<nuxt-link :to="{name: 'dashboard-sadmin-style-create'}" class="btn btn-primary">Create Style</nuxt-link>
		</div>

		<div class="section-body">
			<div class="row bg-white rounded p-3 shadow">
				<div class="d-flex w-100 justify-content-between flex-lg-row flex-column">
					<form class="d-flex mb-3" @submit.prevent="action === 'delete' ? deleteStyle() : ''">
						<select class="form-control" v-model="action">
							<option value="">Select a option</option>
							<option value="delete">Delete selected items</option>
						</select>
						<button type="submit" class="btn btn-primary">Apply Action</button>
					</form>
					<form class="d-flex mb-3" @submit.prevent="search">
						<input class="form-control" type="text" placeholder="Search..." v-model="searchOption.keyword">
						<select class="form-control" v-model="searchOption.collum">
							<option value="name">Search by style</option>
						</select>
						<button type="submit" class="btn btn-primary">
							<i>
								<icon :icon="['fas', 'search']"></icon>
							</i>
						</button>
					</form>
				</div>
				<table class="table table-striped text-center table-responsive-md">
					<thead>
						<tr>
							<th scope="col">
								<input class="form-check-input" type="checkbox" @click="select.length >= 1 ? deselectall():selectAll()" :checked="select.length >= 1">
							</th>
							<th scope="col">Buyer</th>
							<th scope="col">Style</th>
							<th scope="col">Create At</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody class="text-center" v-if="loading">
						<td colspan="8">
							<Loader />
						</td>
					</tbody>
					<tbody class="text-center" v-else-if="styles.data && styles.data.length >= 1">
						<tr v-for="style in styles.data" :key="style.id">
							<th scope="row">
								<input class="form-check-input" type="checkbox" v-model="select" :value="style.id">
							</th>
							<td>{{style.buyer.name}}</td>
							<td>{{style.name}}</td>
							<td>{{style.created_at | date}}</td>
							<td>
								<nuxt-link :to="{name: 'dashboard-sadmin-style-edit-id', params:{id: style.id}}" class="btn btn-icon btn-primary mx-2 my-2">
									<i>
										<icon :icon="['fas', 'edit']"></icon>
									</i>
								</nuxt-link>
								<button class="btn btn-icon btn-danger my-2" @click="deleteStyle(style.id)">
									<i>
										<icon :icon="['fas', 'trash-alt']"></icon>
									</i>
								</button>
							</td>
						</tr>
					</tbody>
					<tbody v-else>
						<td colspan="8" class="pt-3">
							<Not-found message="No style found" />
						</td>
					</tbody>
				</table>
				<pagination :data="styles" @pagination-change-page="getResults" class="justify-content-center mt-3 paginate"></pagination>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		name: "all-styles",
		middleware: "sadmin",
		head() {
			return {
				title: `styles - ${this.appName}`,
			};
		},
		data() {
			return {
				click: true,
				styles: {},
				select: [],
				action: "",
				searchOption: {
					keyword: "",
					collum: "name",
				},
				loading: true,
			};
		},
		methods: {
			//Get Style
			getStyle() {
				this.$axios.get("style").then(
					(response) => {
						this.styles = response.data.styles;
						this.loading = false;
					},
					(error) => {
						$nuxt.$emit("error", error);
					}
				);
			},
			getResults(page = 1) {
				this.$axios.get("style?page=" + page).then((response) => {
					this.style = response.data.style;
				});
			},

			//Confirm Delete
			deleteStyle(id) {
				if (this.click) {
					this.click = false;
					this.$swal
						.fire({
							title: "Are you sure?",
							text: "You won't be able to revert this!",
							icon: "warning",
							showCancelButton: true,
							confirmButtonColor: "#6777ef",
							cancelButtonColor: "#fc544b",
							confirmButtonText: "Yes, delete it!",
						})
						.then((result) => {
							if (result.isConfirmed) {
								let list = id ? [id] : this.select;
								this.$axios
									.post("delete-style", { idList: list })
									.then(
										(response) => {
											this.select = [];
											$nuxt.$emit("triggerStyle");
											$nuxt.$emit("success", response.data);
											this.click = true;
										},
										(error) => {
											$nuxt.$emit("error", error);
											this.click = true;
										}
									);
							} else {
								this.click = true;
							}
						});
				}
			},

			// Select All Data
			selectAll() {
				this.select = [];
				this.styles.data.forEach((style) => {
					this.select.push(style.id);
				});
			},

			//Deselect all data
			deselectall() {
				this.select = [];
			},

			//Search item
			search() {
				if (this.click) {
					this.click = false;
					this.loading = true;
					this.$axios.post("search-style", this.searchOption).then(
						(response) => {
							this.styles = response.data.styles;
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
		},

		created() {
			this.getStyle();
			this.$nuxt.$on("triggerStyle", () => {
				this.getStyle();
			});
		},

		beforeDestroy() {
			this.$nuxt.$off("triggerStyle");
		},
	};
</script>