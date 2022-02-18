<template>
	<div>
		<div class="section-header">
			<h1>Edit Style</h1>
		</div>

		<div class="section-body">
			<form class="row" @submit.prevent="submit">
				<div class="col-lg-12">
					<div class="bg-white p-3 min-h100 rounded card-primary">
						<h3 class="text-center">General Information</h3>
						<div class="form-group">
							<label for="status">Buyer</label>
							<select class="form-control" id="status" v-model="form.buyer_id">
								<option value="">Select a Buyer</option>
								<option :value="buyer.id" v-for="buyer in buyers" :key="buyer.id">{{buyer.name}}</option>
							</select>
							<p class="invalid-feedback" v-if="errors.buyer_id">{{errors.buyer_id[0]}}</p>
						</div>
						<div class="form-group">
							<label for="name">Style Name</label>
							<input type="text" class="form-control" id="name" v-model="form.name">
							<p class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</p>
						</div>
						<button type="submit" class="btn btn-primary">
							<transition name="fade" mode="out-in">
								<Spiner v-if="loading" />
								<span v-else>Create Styles</span>
							</transition>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
	export default {
		name: "edit-style",
		middleware: "sadmin",
		head() {
			return {
				title: `Edit Style - ${this.appName}`,
			};
		},

		data() {
			return {
				form: {
					buyer_id: "",
					name: "",
					status: true,
				},
				buyers: [],
				errors: {},
				click: true,
				loading: false,
			};
		},

		methods: {
			// Get Style
			editStyle() {
				this.$axios.get(`edit-style/${this.$route.params.id}`).then(
					(response) => {
						this.form.buyer_id = response.data.style.buyer_id;
						this.form.name = response.data.style.name;
					},
					(error) => {
						$nuxt.$emit("error", error);
					}
				);
			},

			getBuyerList() {
				this.$axios.get("list-buyer").then(
					(response) => {
						this.buyers = response.data.buyers;
					},
					(error) => {
						$nuxt.$emit("error", error);
					}
				);
			},

			//Submit Form
			submit() {
				if (this.click) {
					this.click = false;
					this.$axios
						.post(`update-style/${this.$route.params.id}`, this.form)
						.then(
							(response) => {
								$nuxt.$emit("success", response.data);
								this.click = true;
								this.$router.push({
									name: "dashboard-sadmin-style",
								});
							},
							(error) => {
								this.errors = error.response.data.errors;
								this.click = true;
							}
						);
				}
			},
		},

		created() {
			this.getBuyerList();
			this.editStyle();
		},
	};
</script>