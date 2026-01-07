    
    <?php
    class tag{

    private ?int  $id_tag=null;
    private string $nom ;
    private string $URLfriendly ;
    private int  $photoCount=0;
    public function __construct($nom,$URLfriendly){
        $this->nom=$nom;
        $this->URLfriendly=$URLfriendly;
    }
        public function getId(): ?int 
        { 
            return $this->id_tag; 
        }

    public function getnom(){
        return $this->nom;
    }
    public function getURLfriendly(){
        return $this->URLfriendly;
    }
        public function getPhotoCount(): int
         {
             return $this->photoCount; 
            }

    }