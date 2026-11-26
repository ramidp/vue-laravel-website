<script setup>
import TeamMemberCard from '../TeamMemberCard.vue';

// members comes from HomeController (team_members table)
defineProps({
    members: { type: Array, required: true },
});
</script>

<template>
    <section id="about" class="section section--alt">
        <div class="container">
            <div class="section__head">
                <h2 class="section__title">The <span>crew</span></h2>
                <p class="section__subtitle">The people behind the ads, pages and flows.</p>
            </div>

            <div class="team-grid">
                <TeamMemberCard
                    v-for="member in members"
                    :key="member.id"
                    :name="member.name"
                    :role="member.role"
                    :photo="member.photo"
                    :initials="member.initials"
                />

                <p v-if="!members.length" class="empty-state">No team members yet.</p>
            </div>
        </div>
    </section>
</template>
