import { useQuery as useTanstackQuery, useMutation, useQueryClient, QueryKey } from '@tanstack/react-query';
import { api, getErrorMessage } from '@/lib/api';
import toast from 'react-hot-toast';

// ── Generic hooks ─────────────────────────────────────────
export const useApiQuery = <T>(key: QueryKey, url: string, options?: any) =>
  useTanstackQuery<T>({
    queryKey: key,
    queryFn: async () => {
      const res = await api.get<any>(url);
      return res.data.data;
    },
    ...options,
  });

export const useApiMutation = <T, V = any>(
  mutationFn: (data: V) => Promise<any>,
  options?: {
    onSuccess?:   (data: T) => void;
    onError?:     (error: unknown) => void;
    invalidateKeys?: QueryKey[];
    successMsg?:  string;
  }
) => {
  const queryClient = useQueryClient();
  return useMutation<T, unknown, V>({
    mutationFn,
    onSuccess: (data) => {
      if (options?.successMsg) toast.success(options.successMsg);
      if (options?.invalidateKeys) {
        options.invalidateKeys.forEach(key => queryClient.invalidateQueries({ queryKey: key as any }));
      }
      options?.onSuccess?.(data);
    },
    onError: (error) => {
      toast.error(getErrorMessage(error));
      options?.onError?.(error);
    },
  });
};

// ── Domain hooks ──────────────────────────────────────────
export const useProfile = () =>
  useApiQuery<any>(['profile'], '/profile');

export const useProjects = (params?: Record<string, any>) =>
  useTanstackQuery({
    queryKey: ['projects', params],
    queryFn: async () => {
      const res = await api.get<any>('/projects', { params });
      return res.data;
    },
  });

export const useProject = (id: string) =>
  useApiQuery<any>(['project', id], `/projects/${id}`);

export const useSkills = (params?: Record<string, any>) =>
  useApiQuery<any>(['skills', params], '/skills');

export const useExperiences = () =>
  useApiQuery<any>(['experiences'], '/experiences');

export const useCertifications = () =>
  useApiQuery<any>(['certifications'], '/certifications');

export const useBlogs = (params?: Record<string, any>) =>
  useTanstackQuery({
    queryKey: ['blogs', params],
    queryFn: async () => {
      const res = await api.get<any>('/blogs', { params });
      return res.data;
    },
  });

export const useBlog = (id: string) =>
  useApiQuery<any>(['blog', id], `/blogs/${id}`);

export const useDashboardStats = () =>
  useApiQuery<any>(['analytics'], '/admin/analytics');
