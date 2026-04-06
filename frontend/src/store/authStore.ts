import { create } from 'zustand';
import { persist } from 'zustand/middleware';
import { api, getErrorMessage } from '@/lib/api';
import type { User } from '@/types';

interface AuthState {
  user:         User | null;
  accessToken:  string | null;
  isLoading:    boolean;
  isAuthenticated: boolean;
  login:     (email: string, password: string) => Promise<void>;
  logout:    () => Promise<void>;
  fetchMe:   () => Promise<void>;
  setToken:  (token: string) => void;
}

export const useAuthStore = create<AuthState>()(
  persist(
    (set, get) => ({
      user:            null,
      accessToken:     null,
      isLoading:       false,
      isAuthenticated: false,

      setToken: (token) => {
        set({ accessToken: token });
        if (typeof window !== 'undefined') localStorage.setItem('accessToken', token);
      },

      login: async (email, password) => {
        set({ isLoading: true });
        try {
          const res = await api.post<any>('/auth/login', { email, password });
          const { user, accessToken } = res.data.data;
          get().setToken(accessToken);
          set({ user, isAuthenticated: true });
        } finally {
          set({ isLoading: false });
        }
      },

      logout: async () => {
        try {
          await api.post('/auth/logout');
        } finally {
          localStorage.removeItem('accessToken');
          set({ user: null, accessToken: null, isAuthenticated: false });
        }
      },

      fetchMe: async () => {
        try {
          const res = await api.get<any>('/auth/me');
          set({ user: res.data.data.user, isAuthenticated: true });
        } catch {
          set({ user: null, isAuthenticated: false });
        }
      },
    }),
    {
      name:    'portfolio-auth',
      partialize: (state) => ({ accessToken: state.accessToken }),
    }
  )
);
