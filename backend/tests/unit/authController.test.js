const mongoose = require('mongoose');
const request  = require('supertest');

// Mock environment before loading app
process.env.NODE_ENV       = 'test';
process.env.JWT_SECRET     = 'test_jwt_secret_at_least_32_chars_long_x';
process.env.JWT_REFRESH_SECRET = 'test_refresh_secret_32_chars_long_xx';
process.env.JWT_EXPIRES_IN = '15m';
process.env.JWT_REFRESH_EXPIRES_IN = '7d';
process.env.MONGODB_URI    = process.env.MONGODB_URI_TEST || 'mongodb://localhost:27017/portfolio_test';

describe('Auth Controller', () => {
  let app;

  beforeAll(async () => {
    app = require('../../src/server');
    await new Promise(r => setTimeout(r, 500));
  });

  afterAll(async () => {
    await mongoose.connection.dropDatabase();
    await mongoose.connection.close();
  });

  describe('POST /api/auth/register', () => {
    it('should register a new user', async () => {
      const res = await request(app)
        .post('/api/auth/register')
        .send({ name: 'Test User', email: 'test@test.com', password: 'Test@123!' });
      expect(res.status).toBe(201);
      expect(res.body.status).toBe('success');
      expect(res.body.data.user.email).toBe('test@test.com');
      expect(res.body.data.accessToken).toBeDefined();
    });

    it('should reject weak password', async () => {
      const res = await request(app)
        .post('/api/auth/register')
        .send({ name: 'Test', email: 'test2@test.com', password: 'weak' });
      expect(res.status).toBe(400);
    });

    it('should reject duplicate email', async () => {
      await request(app).post('/api/auth/register')
        .send({ name: 'User', email: 'dup@test.com', password: 'Dup@1234!' });
      const res = await request(app).post('/api/auth/register')
        .send({ name: 'User', email: 'dup@test.com', password: 'Dup@1234!' });
      expect(res.status).toBe(409);
    });
  });

  describe('POST /api/auth/login', () => {
    beforeAll(async () => {
      await request(app).post('/api/auth/register')
        .send({ name: 'Login Test', email: 'login@test.com', password: 'Login@123!' });
    });

    it('should login with valid credentials', async () => {
      const res = await request(app).post('/api/auth/login')
        .send({ email: 'login@test.com', password: 'Login@123!' });
      expect(res.status).toBe(200);
      expect(res.body.data.accessToken).toBeDefined();
    });

    it('should reject invalid password', async () => {
      const res = await request(app).post('/api/auth/login')
        .send({ email: 'login@test.com', password: 'WrongPass@1!' });
      expect(res.status).toBe(401);
    });

    it('should reject unknown email', async () => {
      const res = await request(app).post('/api/auth/login')
        .send({ email: 'nobody@test.com', password: 'Test@123!' });
      expect(res.status).toBe(401);
    });
  });

  describe('GET /api/auth/me', () => {
    let token;
    beforeAll(async () => {
      const res = await request(app).post('/api/auth/login')
        .send({ email: 'login@test.com', password: 'Login@123!' });
      token = res.body.data.accessToken;
    });

    it('should return current user', async () => {
      const res = await request(app).get('/api/auth/me')
        .set('Authorization', `Bearer ${token}`);
      expect(res.status).toBe(200);
      expect(res.body.data.user.email).toBe('login@test.com');
    });

    it('should reject unauthenticated request', async () => {
      const res = await request(app).get('/api/auth/me');
      expect(res.status).toBe(401);
    });
  });
});
