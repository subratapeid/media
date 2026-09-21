Pagelyne Media
│
├── Core
│   ├── MediaManager
│   ├── MediaService
│   ├── MediaRepository
│   ├── MediaUrlGenerator
│   └── MediaResolver
│
├── Models
│   ├── Media
│   └── MediaAttachment
│
├── Contracts
│   ├── MediaManagerInterface
│   ├── MediaStorageInterface
│   ├── MediaUrlGeneratorInterface
│   └── MediaTransformerInterface
│
├── Storage
│   ├── LocalStorage
│   ├── PublicStorage
│   └── CloudStorage
│
├── Upload
│   ├── UploadManager
│   ├── FileValidator
│   └── FileUploader
│
├── Transform
│   ├── ImageTransformer
│   ├── ThumbnailGenerator
│   └── ImageOptimizer
│
├── Attachments
│   ├── AttachmentManager
│   └── HasMedia
│
├── Collections
│   ├── MediaCollection
│   └── CollectionManager
│
├── Folder
│   ├── FolderManager
│   └── MediaFolder
│
├── Admin
│   ├── Controllers
│   ├── Requests
│   ├── Views
│   └── Routes
│
├── API
│   ├── Controllers
│   ├── Resources
│   └── Routes
│
├── Console
│   ├── CleanupCommand
│   └── OptimizeCommand
│
├── Config
│   └── media.php
│
├── Database
│   ├── Migrations
│   └── Seeders
│
└── Providers
    └── MediaServiceProvider




media/
│
├── composer.json
│
├── config/
│   └── media.php
│
├── database/
│   ├── migrations/
│   │   ├── create_media_table.php
│   │   └── create_media_attachments_table.php
│   └── seeders/
│       └── MediaSeeder.php
│
├── resources/
│   └── views/
│       └── components/
│           ├── picker.blade.php
│           ├── uploader.blade.php
│           └── media-card.blade.php
│
├── src/
│   ├── Contracts/
│   │   ├── MediaRepositoryInterface.php
│   │   └── MediaStorageInterface.php
│   │
│   ├── Models/
│   │   ├── Media.php
│   │   └── MediaAttachment.php
│   │
│   ├── Repositories/
│   │   └── MediaRepository.php
│   │
│   ├── Services/
│   │   ├── MediaService.php
│   │   ├── MediaUploadService.php
│   │   ├── MediaAttachmentService.php
│   │   └── MediaStorageService.php
│   │
│   ├── Storage/
│   │   └── LocalMediaStorage.php
│   │
│   ├── Traits/
│   │   └── HasMedia.php
│   │
│   └── Providers/
│       └── MediaServiceProvider.php
│
└── tests/
    ├── Unit/
    └── Feature/