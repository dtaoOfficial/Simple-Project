import { Head, useForm } from '@inertiajs/react';

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
        schedule: '',
        activities: '',
        outcomes: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/programmes');
    };

    return (
        <>
            <Head title="Add Programme" />
            <div className="mx-auto max-w-md p-6">
                <h1 className="mb-4 text-xl font-semibold">Add Programme</h1>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="mb-1 block">Name</label>
                        <input
                            type="text"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                        />
                        {errors.name && <p className="text-sm text-red-600">{errors.name}</p>}
                    </div>

                    <div>
                        <label className="mb-1 block">Description</label>
                        <textarea
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                            rows={3}
                        />
                        {errors.description && <p className="text-sm text-red-600">{errors.description}</p>}
                    </div>

                    <div>
                        <label className="mb-1 block">Schedule</label>
                        <input
                            type="text"
                            value={data.schedule}
                            onChange={(e) => setData('schedule', e.target.value)}
                            placeholder="e.g. Mon & Wed, 4-5 PM"
                            className="w-full rounded border border-gray-300 p-2"
                        />
                        {errors.schedule && <p className="text-sm text-red-600">{errors.schedule}</p>}
                    </div>

                    <div>
                        <label className="mb-1 block">Activities</label>
                        <textarea
                            value={data.activities}
                            onChange={(e) => setData('activities', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                            rows={3}
                        />
                        {errors.activities && <p className="text-sm text-red-600">{errors.activities}</p>}
                    </div>

                    <div>
                        <label className="mb-1 block">Outcomes</label>
                        <textarea
                            value={data.outcomes}
                            onChange={(e) => setData('outcomes', e.target.value)}
                            className="w-full rounded border border-gray-300 p-2"
                            rows={3}
                        />
                        {errors.outcomes && <p className="text-sm text-red-600">{errors.outcomes}</p>}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Save
                    </button>
                </form>
            </div>
        </>
    );
}
