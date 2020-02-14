<template>
	<v-container>
		<nova-inscricao />
		<inscricao-list />
	</v-container>
</template>
<script>
	import NovaInscricao from "./components/NovaInscricao";
	import InscricaoList from "./components/InscricaoList";
	export default {
	  name : 'Inscricao',
	  components: {
        NovaInscricao, InscricaoList
	  },
	  data() {
	    return {

	    }
	  }
	}
</script>