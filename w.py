import matplotlib.pyplot as plt
import matplotlib.patches as mpatches

def draw_table_relations():
    fig, ax = plt.subplots(figsize=(12, 8))

    ax.set_xlim(0, 12)
    ax.set_ylim(0, 8)
    ax.axis('off')

    # Draw Users Table
    users_box = mpatches.FancyBboxPatch((1, 6), 3, 1, boxstyle="round,pad=0.3", edgecolor="black", facecolor="lightblue")
    ax.add_patch(users_box)
    ax.text(2.5, 6.5, "users", ha="center", va="center", fontsize=12, weight='bold')
    users_text = "id\nusername\npassword\nemail\ncreated_at\ntype\nactive"
    ax.text(2.5, 5.9, users_text, ha="center", va="top", fontsize=10)

    # Draw Suno Accounts Table
    suno_accounts_box = mpatches.FancyBboxPatch((1, 3), 3, 2, boxstyle="round,pad=0.3", edgecolor="black", facecolor="lightgreen")
    ax.add_patch(suno_accounts_box)
    ax.text(2.5, 4.7, "suno_accounts", ha="center", va="center", fontsize=12, weight='bold')
    suno_accounts_text = "id\ncredits_left\nperiod\nmonthly_limit\nmonthly_usage\nsuno_id\nsuno_password\nsuno_cookie\ncreate_date\nactivate_status\nearn_credit"
    ax.text(2.5, 3.8, suno_accounts_text, ha="center", va="top", fontsize=10)

    # Draw Songs Table
    songs_box = mpatches.FancyBboxPatch((7, 3), 3, 2.5, boxstyle="round,pad=0.3", edgecolor="black", facecolor="lightcoral")
    ax.add_patch(songs_box)
    ax.text(8.5, 5.2, "songs", ha="center", va="center", fontsize=12, weight='bold')
    songs_text = "id\ntitle\nimage_url\nlyric\naudio_url\nvideo_url\ncreated_at\nmodel_name\nstatus\ngpt_description_prompt\nprompt\ntype\ntags\nerror_message"
    ax.text(8.5, 3.3, songs_text, ha="center", va="top", fontsize=10)

    # Draw Relations
    ax.annotate("", xy=(4, 6.5), xytext=(7, 4.5),
                arrowprops=dict(arrowstyle="->", color='black', lw=2))

    plt.title('Database Tables and Relations', fontsize=14)
    plt.show()

draw_table_relations()
