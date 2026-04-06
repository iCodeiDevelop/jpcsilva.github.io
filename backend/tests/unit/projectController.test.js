process.env.NODE_ENV = 'test';
process.env.JWT_SECRET = 'test_jwt_secret_at_least_32_chars_long_x';
process.env.JWT_REFRESH_SECRET = 'test_refresh_secret_32_chars_long_xx';
process.env.MONGODB_URI = process.env.MONGODB_URI_TEST || 'mongodb://localhost:27017/portfolio_test_proj';

const mongoose = require('mongoose');
const request  = require('supertest');

describe('Project Controller', () => {
  let app, adminToken;

  beforeAll(async () => {
    app = require('../../src/server');
    await new Promise(r => setTimeout(r, 500));

    // Create and login admin
    const User = require('../../src/models/User');
    const admin = await User.create({ name:'Admin',email:'proj_admin@test.com',password:'Admin@1234!',role:'admin',isActive:true });
    const loginRes = await request(app).post('/api/auth/login')
      .send({ email:'proj_admin@test.com', password:'Admin@1234!' });
    adminToken = loginRes.body.data.accessToken;
  });

  afterAll(async () => {
    await mongoose.connection.dropDatabase();
    await mongoose.connection.close();
  });

  describe('GET /api/projects', () => {
    it('should return empty array initially', async () => {
      const res = await request(app).get('/api/projects');
      expect(res.status).toBe(200);
      expect(res.body.data.projects).toBeInstanceOf(Array);
    });
  });

  describe('POST /api/admin/projects', () => {
    it('should create a project as admin', async () => {
      const res = await request(app)
        .post('/api/admin/projects')
        .set('Authorization', `Bearer ${adminToken}`)
        .send({ title:'Test Project', description:'A test project description', category:'web', status:'published' });
      expect(res.status).toBe(201);
      expect(res.body.data.project.title).toBe('Test Project');
    });

    it('should reject unauthenticated create', async () => {
      const res = await request(app).post('/api/admin/projects')
        .send({ title:'Bad Project', description:'desc', category:'web' });
      expect(res.status).toBe(401);
    });
  });
});
