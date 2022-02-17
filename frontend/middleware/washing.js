export default function ({ store, redirect }) {
	if (!store.getters.isWashing) {
		return redirect('/dashboard')
	}
}