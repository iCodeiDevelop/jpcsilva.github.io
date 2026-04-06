const multer = require('multer');
const path   = require('path');
const { v4: uuidv4 } = require('uuid');
const { AppError } = require('../utils/errors');

const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, path.join(process.cwd(), process.env.UPLOAD_PATH || './uploads/images'));
  },
  filename: (req, file, cb) => {
    const ext = path.extname(file.originalname).toLowerCase();
    cb(null, `${uuidv4()}${ext}`);
  },
});

const fileFilter = (req, file, cb) => {
  const allowed = (process.env.ALLOWED_IMAGE_TYPES || 'image/jpeg,image/png,image/webp')
    .split(',').map(t => t.trim());
  if (allowed.includes(file.mimetype)) {
    cb(null, true);
  } else {
    cb(new AppError(`Unsupported file type: ${file.mimetype}. Allowed: ${allowed.join(', ')}`, 400), false);
  }
};

const upload = multer({
  storage,
  fileFilter,
  limits: { fileSize: parseInt(process.env.MAX_FILE_SIZE) || 5 * 1024 * 1024 },
});

exports.uploadSingle  = upload.single('image');
exports.uploadMultiple = upload.array('images', 10);

exports.uploadFields = upload.fields([
  { name: 'image',  maxCount: 1  },
  { name: 'images', maxCount: 10 },
  { name: 'resume', maxCount: 1  },
]);
