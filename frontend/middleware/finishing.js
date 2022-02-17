export default function ({ store, redirect }) {
	if (!store.getters.isFinishing) {
		return redirect('/dashboard')
	}
}