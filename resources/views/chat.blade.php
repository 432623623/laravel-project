    <script>
      document.addEventListener('livewire:initialized', () => {
          Livewire.hook('morph.added', (element) => {
              if (element.el.classList.contains("chat-self") || element.el.classList.contains("chat-other")) {
                const chat = document.querySelector("#chat")
                chat.scrollTop = chat.scrollHeight;
              }
          })
      })
    </script>


