export default function ({ store, redirect }) {
	if (!store.getters.isCutting) {
		return redirect('/dashboard')
	}
}