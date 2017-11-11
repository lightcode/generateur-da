:warning: **Ce projet n'est plus maintenu.**

---

# Générateur de Diagrammes d'Action ASCII

Le Générateur de Diagrammes d'Action (DA) est un outil conçu pour simplifier la création de diagrammes ASCII représentant des séquences d'actions. Il offre une interface conviviale qui utilise des raccourcis clavier intuitifs, tout en respectant une syntaxe légère et facile à comprendre (voir [la syntaxe](/docs/syntaxe.pdf)).

<p align="center">
  <img src="/docs/screenshot.png?raw=true" alt="Capture d'écran"/>
</p>

Pour créer un nouveau DA, il suffit de cliquer sur "Nouveau". Pour générer le DA actuel, appuyez sur "Traduire". Si vous souhaitez enregistrer temporairement votre travail, utilisez l'option "Enregistrer". Vous pourrez ensuite ouvrir votre DA ultérieurement en utilisant l'identifiant enregistré, par exemple, en cas de problème avec votre navigateur. Il est également possible de partager votre DA, mais gardez à l'esprit que tout le monde aura la possibilité de le modifier.

À partir du 1ᵉʳ novembre 2021, ce projet ne sera plus hébergé. Pour continuer à l'utiliser, je vous recommande de télécharger le code source et de déployer une version locale en utilisant Docker.

Pour déployer localement, suivez ces étapes :

```bash
docker build -t lightcode/generateur-da .
docker run -p 80:80 lightcode/generateur-da
```
